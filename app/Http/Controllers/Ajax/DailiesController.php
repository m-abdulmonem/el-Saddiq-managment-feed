<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Dailies\Daily;
use App\Services\Clients\bills\InvoicesServices;
use Illuminate\Http\Request;

class DailiesController extends Controller
{

    public function __construct(Request $request)
    {
        if (!$request->ajax())
            redirect("/");
    }

    protected $folder = "site.dailies";
    protected $trans = "dailies";
    protected $perm = "receipts";

    public function index(Request $request)
    {
        if ($request->ajax()){
            return datatables()->of( Daily::latest()->get())
                ->addIndexColumn()
                ->addColumn("user",function ($data){
                    return $this->user($data);
                })
                ->addColumn("date",function ($data){
                    return $data->created_at->format("Y-m-d");
                })
                ->addColumn("time_in",function ($data){
                    return hour_in_ar($data->time_in->format("h:i:s a"));
                })
                ->addColumn("time_out",function ($data){
                    return $data->time_out ? hour_in_ar($data->time_out->format("h:i:s a")) : "-";
                })
                ->addColumn("inc_dec",function ($data){
                    return currency($data->inc_dec);
                })
                ->addColumn("net",function ($data){
                    return currency($data->net_sales);
                })
                ->addColumn('action', function($data){

//                $btn = $this->btnPaidSalary($data);
//                $btn .= btn_view($this->perm,"users",$data);
//                $btn .= btn_update($this->perm,"users",$data);
//                $btn .= btn_delete($this->perm,"users",$data);

//                return $btn;
                })
                ->rawColumns(['action','user'])
                ->make(true);
        }
    }

    public function close(Daily $daily,InvoicesServices $invoice,Request $request)
    {
        $this->validate($request,[
            'balance' => 'required'
        ]);

        $update = $daily->today()->update([
            'net_sales' => $daily->netSales(),
            'inc_dec' => ($request->balance - $daily->netSales()),
            'time_out' => now()
        ]);

        return $update ? jsonSuccess("",route("ajax.dailies.print")) : jsonError(trans("$this->trans.alert_daily_not_saved"));
    }

    public function print(Daily $daily)
    {
        $data = [
            'trans' => $this->trans,
            'daily' => $daily->latest()->first(),
        ];
        return view("$this->folder.print.index",$data);
    }

    private function user($data)
    {
        $href = route("users.show",$data->user->id);
        return "<a class='btn btn-link info-color' href='$href'>{$data->user->name()}</a>";
    }
}
