<?php

namespace App\Http\Controllers\Ajax\Balances;

use App\Http\Controllers\Controller;
use App\Models\Chick\ChickOrder;
use App\Models\Client\ClientBalance;
use App\Models\Supplier\SupplierBalance;
use App\Services\Balances\ClientServices;
use App\Services\Balances\SupplierServices;
use Illuminate\Http\Request;

class AjaxBalancesController extends Controller
{

    /**
     * @var SupplierBalance
     */
    private $supplierBalance;
    /**
     * @var ClientBalance
     */
    private $clientBalance;
    /**
     * @var SupplierServices
     */
    private $supplierServices;
    /**
     * @var ClientServices
     */
    private $clientServices;

    /**
     * AjaxBalancesController constructor.
     *
     * @param SupplierBalance $supplierBalance
     * @param ClientBalance $clientBalance
     * @param SupplierServices $supplierServices
     */
    public function __construct(SupplierBalance $supplierBalance, ClientBalance $clientBalance,SupplierServices $supplierServices,ClientServices $clientServices)
    {

        $this->supplierBalance = $supplierBalance;
        $this->clientBalance = $clientBalance;
        $this->supplierServices = $supplierServices;
        $this->clientServices = $clientServices;
    }


    /**
     * get all chick order transactions
     *
     * for supplier
     *
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function chickSupplier(Request $request,$id = null)
    {
        if ($request->ajax()){
            $data = $request->data == "chick-order-balance"
                ? $this->supplierServices->byOrders($id,$request)
                : $this->supplierServices->sort($request,$id);

            return datatables()->of( $data )
                ->addIndexColumn()
                ->addColumn("supplier",function ($data){
                    return $this->supplierLink($data);
                })
                ->addColumn("type",function ($data){
                    return $data->name();
                })
                ->addColumn("paid",function ($data){
                    return currency( $data->paid );
                })
                ->addColumn("remaining",function ($data){
                    return currency( $data->remaining_amount );
                })
                ->addColumn("date",function ($data){
                    return $data->created_at->diffForHumans();
                })
                ->addColumn("user",function ($data){
                    return $this->userLink($data);
                })
                ->rawColumns(['supplier','user'])
                ->make(true);
        }
    }

    public function client(Request $request,ChickOrder $order = null)
    {
        if ($request->ajax()){
            $data = $request->data == "chick-order-balance"
                ? $this->clientServices->byOrders($request)
                : $this->clientServices->byBooking($order);

            return datatables()->of( $data )
                ->addIndexColumn()
                ->addColumn("client",function ($data){
                    return $this->clientLink($data);
                })
                ->addColumn("transaction",function ($data){
                    return $data->name();
                })
                ->addColumn("paid",function ($data){
                    return currency( $data->paid );
                })
                ->addColumn("rest",function ($data){
                    return currency( $data->remaining_amount );
                })
                ->addColumn("date",function ($data){
                    return $data->created_at->diffForHumans();
                })
                ->addColumn("user",function ($data){
                    return $this->userLink($data);
                })
                ->rawColumns(['client','user'])
                ->make(true);
        }
    }


    /**
     * redirect route to Supplier page profile
     *
     * @param $data
     * @return string
     */
    private function supplierLink($data)
    {
        return "<a class='info-color' href='" . route("suppliers.show",$data->supplier->id) . "'
                   >{$data->supplier->name()}</a>";
    }

    /**
     * redirect route to Supplier page profile
     *
     * @param $data
     * @return string
     */
    private function clientLink($data)
    {
        return "<a class='info-color' href='" . route("clients.show",$data->clients->id) . "'
                   >{$data->clients->name()}</a>";
    }



    /**
     * redirect route to user page profile
     *
     * @param $data
     * @return string
     */
    private function userLink($data)
    {
        return "<a class='info-color' href='" . route("users.show",$data->user->id) . "'>{$data->user->name()}</a>";
    }
    
}
