<?php

namespace App\Http\Controllers\Ajax\Clients;

use App\Http\Controllers\Controller;
use App\Models\Client\Client;
use App\Services\Balances\BalancesServices;
use App\Services\Balances\ClientServices;
use App\Services\Clients\ClientsServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientsController extends Controller
{

    protected $perm = "client";

    protected $trans = "clients/clients";

    protected $folder = "site.clients";
    /**
     * @var Client
     */
    private $client;
    /**
     * @var BalancesServices
     */
    private $balances;

    /**
     * ClientsController constructor.
     *
     * @param ClientsServices $client
     * @param BalancesServices $balances
     */
    public function __construct(ClientsServices $client,BalancesServices $balances)
    {
        $this->client = $client;
        $this->balances = $balances;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax())
            return datatables()->of( $this->client->byType($request->type) )
                ->addIndexColumn()
                ->addColumn("address",function ($data){
                    return $data->limitAddress();
                })
                ->addColumn("name",function ($data){
                    return $data->name();
                })
                ->addColumn("balances",function ($data){
                    return $data->latestBalance();
                })
                ->addColumn("creditor",function ($data){
                    return currency($data->creditor());
                })
                ->addColumn("debtor",function ($data){
                    return currency($data->debtor());
                })
                ->addColumn("latest_bill",function ($data){
                    return $data->latestBill("$this->trans.alert_no_bill_found");
                })
                ->addColumn('action', function($data){
                    //view bill button
                    $btn = btn_view($this->perm,"clients",$data);
                    //update button
                    $btn .= $this->btnUpdate($data);
                    //delete button
                    $btn .= btn_delete($this->perm,"clients",$data) ;

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }


    public function products(ClientsServices $client, Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of($client->sortProducts($request))
                ->addIndexColumn()
                ->addColumn("name",function ($data){
                    return $this->productLink($data);
                })
                ->addColumn("type",function ($data){
                    return ($data instanceof ClientProductReturn)
                        ? trans("clients/bills.discarded_product")
                        : trans("clients/bills.sold_product");
                })
                ->addColumn("quantity",function ($data){
                    return  num_to_ar($data->pivot->quantity );
                })
                ->addColumn("stock",function ($data){
                    return $this->stockLink($data);
                })
                ->addColumn("piece_price",function ($data){
                    return currency($data->pivot->piece_price);
                })
                ->addColumn("price",function ($data){
                    return currency($data->pivot->price);
                })
                ->addColumn("weight",function ($data){
                    return num_to_ar($data->weight);
                })
                ->addColumn("total_weight",function ($data){
                    return num_to_ar($data->pivot->quantity * $data->weight);
                })
                ->rawColumns(["name","stock","expired_at"])
                ->make(true);
        }//end if cond
    }

    public function balances(ClientsServices $client,Request $request)
    {
        if ($request->ajax()) {
            if ($request->startDate || $request->end)
                $data = $client->balance()->whereBetween("created_at",[startDate($request->startDate),endDate($request->end)])->latest()->get();
            elseif ($type = $request->type)
                $data = $client->balance()->where("type",$type)->latest()->get();
            else
                $data = $client->balance()->latest();

            return $this->balances->client($data);
        }
    }

    public function invoicesGraph(ClientsServices $client,Request $request)
    {
        return json($client->invoicesGraph($request->start,$request->end));
    }

    public function quantityGraph(ClientsServices $client,Request $request)
    {
        return json($client->quantityGraph($request->start,$request->end));
    }

    public function consumptionGraph(ClientsServices $client,Request $request)
    {
        return json($client->consumptionGraph($request->start,$request->end));
    }

    public function bookingGraph(ClientsServices $client,Request $request)
    {
        return json($client->bookingGraph($request->start,$request->end));
    }

    public function bookingQuantityGraph(ClientsServices $client,Request $request)
    {
        return json($client->bookingQuantityGraph($request->start,$request->end));
    }

    public function chicksConsumptionGraph(ClientsServices $client, Request $request)
    {
        return json($client->chicksConsumptionGraph($request->start,$request->end));
    }

    public function gainLossGraph(ClientsServices $client,Request $request)
    {
        return json($client->gainLossGraph($request->start,$request->end));
    }


    public function names(ClientsServices $clients)
    {
        $data = [];
        foreach ($clients->all() as $client)
            $data[] = [
                'id' => $client->id,
                'text' => $client->name(),
                'phone' => $client->phone,
                'credit'=> $client->credit_limit,
                'remaining' => ($client->credit_limit - $client->creditor()),
                'limit'=> $client->maximum_repayment_period
            ];
        return json($data);
    }
    /**
     *
     * @param $keyword
     * @return JsonResponse
     */
    public function search($keyword)
    {
        $search = search( $keyword , $this->client->pluck("name")->toArray() );
//
        $data = [
            "search"=>  [
                'mean' => $search["closest"],
                'client' => $this->client->where("name", $search["closest"])->first()
            ],
            "clients" => $this->client->searchName($keyword)
        ];

        return jsonSuccess("search in clients", $data );
    }


    /**
     * get stock view page link
     *
     * @param $data
     * @return string
     */
    public function stockLink($data)
    {
        return "<a class='info-color' href='".route("stocks.show",$data->pivot->stock_id)."'>{$data->pivot->stock->name()}</a>";
    }

    /**
     * get product view page link
     *
     * @param $data
     * @return string
     */
    public function productLink($data)
    {
        return "<a class='info-color' href='".route("products.show",$data->id)."'>{$data->name()}</a>";
    }

    /**
     *
     * @param $data
     * @return string
     */
    private function btnUpdate($data)
    {
        $perm =  user_can("update $this->perm") ? "btn-update" : "disabled";
        $trader = $data->is_trader ? "true" :"false";
        return "<button class='btn btn-info $perm'
                        data-id='$data->id'
                        data-name='$data->name'
                        data-address='$data->address'
                        data-phone='$data->phone'
                        data-discount='$data->discount'
                        data-trader='options_$trader'><i class='fa fa-edit'></i></button>";
    }

}
