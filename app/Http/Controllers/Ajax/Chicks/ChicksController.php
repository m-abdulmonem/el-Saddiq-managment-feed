<?php

namespace App\Http\Controllers\Ajax\Chicks;

use App\Services\Balances\BalancesServices;
use App\Services\Balances\ClientServices;
use App\Services\Chicks\ChicksServices;
use App\Http\Controllers\Controller;
use App\Services\Supplier\SupplierServices;
use Illuminate\Http\Request;
use App\Models\Chick\Chick;

class ChicksController extends Controller
{

    protected $folder = "admin.chicks";

    protected $trans = "chicks/chicks";

    protected $perm = "chick";

    /**
     * @var Chick
     */
    private $balances;
    /**
     * @var ChicksServices
     */
    private $services;

    /**
     * ChicksController constructor.
     * @param ChicksServices $services
     * @param BalancesServices $balances
     */
    public function __construct(ChicksServices $services, BalancesServices $balances)
    {
        $this->services = $services;
        $this->balances = $balances;
    }

    public function index(Request $request,ChicksServices $chick)
    {
        if ($request->ajax())
            return datatables()->of( $chick->sort($request) )
                ->addIndexColumn()
                ->addColumn("supplier",function ($data){
                    return $this->linkSupplier($data);
                })
                ->addColumn("type",function ($data){
                    return trans("$this->trans.option_" . $data->type);
                })
                ->addColumn("price",function ($data){
                    return currency(($order = $data->orders()->latest()->first()) ? $order->price :0);
                })
                ->addColumn("sale_price",function ($data){
                    return currency(($order = $data->orders()->latest()->first()) ? $order->chick_price :0);
                })
                ->addColumn("profit",function ($data){
                    return currency($data->profit);
                })
                ->addColumn("quantity",function ($data){
                    return num_to_ar($data->orders->sum("quantity"));
                })
                ->addColumn("gain",function ($data){
                    return currency($data->debt()->sum("gain"));
                })
                ->addColumn("loss",function ($data){
                    return currency($data->debt()->sum("loss"));
                })
                ->addColumn('action', function($data){

                    $btn = btn_view($this->perm,"chicks",$data);

                    $btn .= $this->btnUpdate($data);

                    $btn .= btn_delete($this->perm,"chicks",$data) ;

                    return $btn;
                })
                ->rawColumns(['action','supplier'])
                ->make(true);
    }

    public function supplierBalances(ChicksServices $chick,Request $request)
    {
        return $this->balances->supplier($chick->supplierBalances($request));
    }

    public function clientBalances(ChicksServices $chick, Request $request)
    {
        return $this->balances->client($chick->clientBalances($request));
    }

    /**
     *
     *
     * @param ChicksServices $chick
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function consumptionGraph(ChicksServices $chick,Request $request)
    {
        return json($chick->consumptionGraph($request));
    }

    public function incomeStatementGraph(ChicksServices $chick,Request $request)
    {
        return json($chick->debtGraph($request));
    }
    /**
     * @param Chick $chick
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function prices(ChicksServices $chick,Request $request)
    {
        return json($chick->pricesStatics($request));
    }

    /**
     * @param Chick $chick
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function locations(ChicksServices $chick,Request $request)
    {
        return json($chick->locationsStatics($request));
    }

    public function linkSupplier($data)
    {
        return "<a class='info-color' href='" . route("suppliers.show",$data->supplier->id) . "'>" . $data->supplier->name . "</a>";;
    }
    

    /**
     * @param $data
     * @return string
     */
    public function btnUpdate($data)
    {
        $perm = user_can("update $this->perm") ? "btn-update" : "disabled";
        return "<button class='btn btn-info $perm'
                       data-id='$data->id' 
                       data-name='$data->name'
                       data-type='$data->type'
                       data-supplier='$data->supplier_id'><i class=\"fa fa-edit\"></i></button>";
    }
}
