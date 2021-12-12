<?php

namespace App\Http\Controllers\Ajax\Users;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Product\NotifyExpired;
use App\Models\User;
use App\Services\Balances\BalancesServices;
use App\Services\User\Balances\ClientBalanceServices;
use App\Services\User\Balances\SupplierBalanceServices;
use App\Services\User\UserServices;
use Illuminate\Http\Request;

class UsersControllers extends Controller
{

    protected $trans = "users/users";

    protected $perm = "user";
    /**
     * @var BalancesServices
     */
    private $balances;

    private $supplierBalances;
    private $clientBalances;

    public function __construct(BalancesServices $balances)
    {
        $this->balances = $balances;
        $this->supplierBalances = new SupplierBalanceServices();
        $this->clientBalances = new ClientBalanceServices();
    }

    public function index()
    {

//       $s = now()->subHours(20)->diffInHours(now());
//
//       dd($s);
        if (request()->ajax()) {
            return datatables()->of( UserServices::latest()->where("id","!=",1)->get())
                ->addIndexColumn()
                ->addColumn("name",function ($data){
                    return '<img class="table-img" src="' . image($data->picture,true) .'"/> '. $data->name;
                })
                ->addColumn("address",function ($data){
                    return str_limit($data->address,100);
                })
                ->addColumn("salary",function ($data){
                    return currency($data->salary);
                })
                ->addColumn("salary_type",function ($data){
                    return trans("$this->trans.$data->salary_type");
                })
                ->addColumn("balances",function ($data){
                    return currency(0);
                })
                ->addColumn("job",function ($data){
                    return ($name = $data->job) ? $name->name: "-";
                })
                ->addColumn("status",function ($data){
                    return trans("$this->trans.option_$data->is_active");
                })
                ->addColumn('action', function($data){
                    $btn = $this->btnAttendance($data);
                    $btn .= $this->btnPaidSalary($data);
                    $btn .= btn_view($this->perm,"users",$data);
                    $btn .= btn_update($this->perm,"users",$data);
                    $btn .= btn_delete($this->perm,"users",$data);

                    return $btn;
                })
                ->rawColumns(['action','name'])
                ->make(true);

        }//end if cond
    }

    public function clientBalances(UserServices $user,Request $request)
    {
        if ($request->ajax()){
            if ($request->startDate || $request->end)
                $data = $user->clientBalance()->whereBetween("created_at",[startDate($request->startDate),endDate($request->end)])->latest()->get();
            elseif ($type = $request->type)
                $data = $user->clientBalance()->where("type",$type)->latest()->get();
            else
                $data = $user->clientBalance()->latest()->get();

            return $this->balances->client($data);//$this->clientBalances->byUser($user->id)
        }
    }
    public function supplierBalances(UserServices $user,Request $request)
    {
        if ($request->ajax())
            return $this->balances->supplier($this->supplierBalances->byUser($user->id));
    }

    public function btnAttendance($data)
    {
        $attendance = $data->attendances()->byNow($data->id);

        if ($attendance->first() && !$attendance->whereNull("time_out")->first())
            return null;
        return (!$attendance->first())
            ? "<button class='btn btn-light btn-create-attendance' data-id='$data->id' title='".trans("users/attendances.create.attendance")."'><i class='fas fa-user-clock'></i></button>"
            : "<button class='btn btn-light btn-create-departure' data-id='$data->id' title='".trans("users/attendances.create.departure")."'><i class='fa fa-sign-out-alt'></i></button>";

    }


    public function attendance(User $user)
    {
        $data = $user->attendances()->create([
            'time_in' => now()->format("H:i:s"),
            'date' => now()->format("Y-m-d"),
            'is_exist' => true,
        ]);

        return jsonSuccess(trans("users/attendances.alert_success_create"),$data);
    }
    
    public function departure(User $user)
    {
       $attendance = $user->attendances()->byNow($user->id)->first()->update([
           'time_out' => now()
       ]);

       return jsonSuccess(trans("users/attendances.alert_success_update"),$attendance);
        
    }
    
    public function notifications(NotifyExpired $notifyExpired){
        $callback = function ($c,$notify){
            return $c->push([
                'id' => $notify->id,
                'text' => $notify->text,
                'remaining_days' => $notify->remaining_days,
                'quantity' => $notify->quantity,
                'expired_at' => $notify->product->expired_at,
                'since' => $notify->created_at->diffInDays(now())
            ]);
        };
        return json(mapArray($notifyExpired->where('user_id',auth()->id())->where("is_read",false)->get(),$callback)->toArray());
    }


    public function markNotification(NotifyExpired $notify)
    {
        return jsonSuccess(trans("$this->trans.alert_success_marked"),$notify->update(['is_read' => true]));
    }

    public function btnPaidSalary($data)
    {
        return "<button class='btn btn-primary btn-paid-salary' 
                        data-id='$data->id' 
                        data-salary='{$data->calcSalary()}' 
                        data-salary-type='$data->salary_type'
                        data-disabled='{$data->disabled()}'
                        data-id='$data->id'
                        ><i class='far fa-money-bill-alt'></i></button>";
    }
}
