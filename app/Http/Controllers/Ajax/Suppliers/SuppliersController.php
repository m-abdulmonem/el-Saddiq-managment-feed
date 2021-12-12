<?php

namespace App\Http\Controllers\Ajax\Suppliers;

use App\Http\Controllers\Controller;
use App\Models\Supplier\SupplierBalance;
use App\Services\Balances\BalancesServices;
use App\Services\Supplier\SupplierServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{

    protected $trans = "users";
    protected $perm = "supplier";
    /**
     * @var SupplierServices
     */
    private $supplier;
    /**
     * @var BalancesServices
     */
    private $balances;

    public function __construct(SupplierServices $supplier,BalancesServices $balances)
    {
        $this->supplier = $supplier;
        $this->balances = $balances;
    }

    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of( $this->supplier->all())
                ->addIndexColumn()
                ->addColumn("name",function ($data){
                    return $data->name();
                })
                ->addcolumn("phone",function ($data){
                    return num_to_ar($data->phone);
                })
                ->addColumn("address",function ($data){
                    return str_limit($data->address,100);
                })
                ->addColumn("balances",function ($data){
                    return $data->balances();
                })
                ->addColumn("creditor",function ($data){
                    return $data->creditor();
                })
                ->addColumn("debtor",function ($data){
                    return $data->debtor();
                })
                ->addColumn("latest_bill",function ($data){
                    return $data->latestBill();
                })
                ->addColumn('action', function($data){
                    //view supplier button
                    $btn = btn_view($this->perm,"suppliers",$data);
                    //update button
                    $btn .= $this->btnUpdate($data);
                    //delete button
                    $btn .= btn_delete($this->perm,"suppliers",$data);

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * @param SupplierServices $supplier
     * @param Request $request
     * @return mixed
     */
    public function balances(SupplierServices $supplier,Request $request)
    {
        if ($request->ajax()) {
            if ($request->startDate || $request->end)
                $data = $supplier->balance()->whereBetween("created_at",[startDate($request->startDate),endDate($request->end)])->latest()->get();
            elseif ($type = $request->type)
                $data = $supplier->balance()->where("type",$type)->latest()->get();
            else
                $data = $supplier->balance()->latest();

            return $this->balances->supplier($data);
        }
    }

    /**
     * @param SupplierServices $supplier
     * @param Request $request
     * @return JsonResponse
     */
    public function quantityGraph(SupplierServices $supplier,Request $request)
    {
        return json($supplier->quantityGraph($request->start,$request->end));
    }

    /**
     * @param SupplierServices $supplier
     * @param Request $request
     * @return JsonResponse
     */
    public function billsGraph(SupplierServices $supplier,Request $request)
    {
        return json($supplier->billsGraph($request->start,$request->end));
    }

    /**
     * @param SupplierServices $supplier
     * @param Request $request
     * @return JsonResponse
     */
    public function productsGraph(SupplierServices $supplier,Request $request)
    {
        return json($supplier->productsGraph($request->start,$request->end));
    }

    /**
     * @param SupplierServices $supplier
     * @param Request $request
     * @return JsonResponse
     */
    public function chicksQuantityGraph(SupplierServices $supplier,Request $request)
    {
        return json($supplier->chicksQuantityGraph($request->start,$request->end));
    }
    /**
     * @param SupplierServices $supplier
     * @param Request $request
     * @return JsonResponse
     */
    public function chicksGraph(SupplierServices $supplier,Request $request)
    {
        return json($supplier->chicksGraph($request->start,$request->end));
    }

    /**
     * @param SupplierServices $supplier
     * @param Request $request
     * @return JsonResponse
     */
    public function ordersGraph(SupplierServices $supplier,Request $request)
    {
        return json($supplier->ordersGraph($request->start,$request->end));
    }


    /**
     * @param SupplierServices $supplier
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function incomeStatementGraph(SupplierServices $supplier, Request $request)
    {
        return json($supplier->incomeStatementGraph($request->start,$request->end));
    }



    /**
     *
     * @param $data
     * @return string
     */
    private function btnUpdate($data)
    {
        $perm =  user_can("update $this->perm") ? "btn-update" : "disabled";

        return "<button class='btn btn-info $perm' id='item-$data->id'
                        data-id='$data->id' 
                        data-name='$data->name'
                        data-phone='$data->phone'
                        data-my-code='$data->my_code'
                        data-discount='$data->discount'
                        data-address='$data->address'
                        ><i class='fa fa-edit'></i></button>";
    }
}
