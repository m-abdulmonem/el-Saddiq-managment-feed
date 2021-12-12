<?php

namespace App\Http\Controllers\Ajax\Chicks;

use App\Models\Supplier\SupplierBalance;
use App\Services\Balances\BalancesServices;
use App\Services\Chicks\OrdersServices;
use App\Models\Client\ClientBalance;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Chick\ChickOrder;
use App\Models\Chick\ChickPrice;
use Illuminate\Http\Request;
use Exception;

class OrdersController extends Controller
{

    protected $trans = "chicks/orders";

    protected $perm = "chick_order";

    /**
     * @var ChickOrder
     */
    private $order;
    /**
     * @var OrdersServices
     */
    private $services;
    /**
     * @var BalancesServices
     */
    private $balance;

    /**
     * AjaxChickOrdersController constructor.
     *
     * @param ChickOrder $order
     * @param OrdersServices $services
     * @param BalancesServices $balance
     */
    public function __construct(ChickOrder $order, OrdersServices $services, BalancesServices $balance)
    {
        $this->order = $order;
        $this->services = $services;
        $this->balance = $balance;
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            return datatables()->of( $this->query($request) )
                ->addIndexColumn()
                ->addColumn("price",function ($data){
                    return currency( $data->price );
                })
                ->addColumn("purchase_price",function ($data){
                    return currency( ($data->price ) ? $data->price / $data->quantity : 0 );
                })
                ->addColumn("sale_price",function ($data){
                    return currency( $data->chick_price );
                })
                ->addColumn("quantity",function ($data){
                    return num_to_ar( $data->booking()->sum("quantity") );
                })
                ->addColumn("status",function ($data){
                    return trans("$this->trans.option_" . $data->is_came);
                })
                ->addColumn("chick",function ($data){
                    return $data->chick->name;
                })
                ->addColumn("gain",function ($data){
                    return currency($this->services->debt($data)->sum('gain'));
                })
                ->addColumn("loss",function ($data){
                    return currency($this->services->debt($data)->sum('loss'));
                })
                ->addColumn("date",function ($data){
                    return $data->created_at->diffForHumans();
                })
                ->addColumn("came",function ($data){
                    return $this->btnArrived($data);
                })
                ->addColumn('action', function($data){

                    $btn = $this->btnOrderFromSupplier($data);

                    $btn .= $this->btnArriveAt($data);

                    $btn .= btn_view($this->perm,"chicks.orders",$data);

                    $btn .= $this->btnUpdate($data);

                    $btn .= btn_delete($this->perm,"chicks.orders",$data) ;

                    return $btn;
                })
                ->rawColumns(['action','came'])
                ->make(true);
        }//end if cond
    }

    /**
     * get supplier transactions
     *
     * @param Request $request
     * @param OrdersServices $order
     * @return mixed
     */
    public function supplierBalances(Request $request,OrdersServices $order)
    {
        if ($request->ajax()) {
            if ($request->startDate || $request->end)
                $data = $order->balances()->whereBetween("created_at",[startDate($request->startDate),endDate($request->end)])->latest()->get();
            elseif ($type = $request->type)
                $data = $order->balances()->where("type",$type)->latest()->get();
            else
                $data = $order->balances()->latest()->get();

            return $this->balance->supplier($data);
        }
    }

    /**
     * get clients transactions
     *
     * @param Request $request
     * @param OrdersServices $order
     * @return mixed
     */
    public function clientBalances(Request $request,OrdersServices $order)
    {
        if ($request->ajax())
            return $this->balance->client($order->clientBalances($request));
    }

    /**
     * @param Request $request
     * @param ChickOrder $order
     * @return JsonResponse
     */
    public function arrived(Request $request,OrdersServices $order)
    {
        $this->updateOrder($request,$order)
            ->createPrice($order,$request->chick_price)
            ->createTransaction($request,$order);

        return jsonSuccess(trans("$this->trans.alert_arrived_sent"), $this->sendSms($order));
    }

    /**
     * @param OrdersServices $order
     * @return void
     */
    public function requestOrder(OrdersServices $order)
    {
        return jsonSuccess("",$order->smsRequestOrder());
    }

    /**
     * @param Request $request
     * @param ChickOrder $order
     * @return JsonResponse
     */
    public function arrivedAt(Request $request,ChickOrder $order)
    {
        $data = $this->services->arriveAt($order,$request->arrived_at);

        return jsonSuccess(trans("$this->trans.alert_success_save"),$data);
    }


    /**
     * @param $order
     * @return mixed
     */
    private function sendSms(ChickOrder $order)
    {
        $collect = collect();

        foreach ($order->booking()->get() as $booking)
            foreach ($booking->client()->get() as $client)
                $collect->push($this->services->smsArrived($client));

        return $collect->toArray();
    }


    /**
     *
     * @param $order
     * @param $price
     * @return
     */
    private function createPrice($order,$price)
    {
        $order->chick->prices()->create(['price' =>$price]);
        return $this;
    }

    /**
     * update chick order record
     *
     * @param Request $request
     * @param $order
     * @return
     */
    private function updateOrder(Request $request,$order)
    {
        $order->update([
            'is_came'=> true,
            'quantity' => $order->booking()->sum("quantity"),
            'price' => $request->price,
            'chick_price' =>$request->chick_price,
            'arrived_at' => now()
        ]);
        return $this;
    }

    /**
     * create transaction in supplier balance table
     * with the amount of chick order money value
     *
     * @param Request $request
     * @param $order
     */
    private function createTransaction(Request $request,$order)
    {
        $order->balances()->create([
            'remaining_amount' => $request->price - $request->paid,
            'paid' => $request->paid,
            'type' => "payment",
            'code' => SupplierBalance::code(),
            'supplier_id' => $order->chick->supplier_id,
            'user_id' => auth()->id()
        ]);
    }


    private function query($request)
    {
        if ($request->data == "byUser")
            return  $this->services->byUser($request->user);

        return $request->data == "chick-orders" ? $this->services->byChick($request->id) : $this->services->byStatus($request->status);
    }


    private function btnArriveAt($data)
    {
        if (!$data->is_came)
            return "<button class='btn btn-dark btn-arrive-at' 
                    title='".trans("$this->trans.order_arrive_date")."'
                    data-id='$data->id'>
                    <i class='fas fa-calendar'></i></i></button>";
    }

    private function btnOrderFromSupplier($data)
    {
        $trans = trans("$this->trans.order_from_supplier") ;

        if (!$data->is_came)
            return "<button class='btn btn-primary btn-order-from-supplier' 
                    title='$trans'
                    data-id='$data->id' 
                    data-supplier='$data->supplier_id'>
                    <i class='fas fa-truck-moving'></i></button>";
    }

    /**
     * @param $data
     * @return string
     */
    private function btnUpdate($data)
    {
        $clicked = user_can("update $this->perm") ? "btn-update" : "disabled";

        return "<button class='btn btn-info $clicked'
                    data-id='$data->id'
                    data-name='$data->name'
                    data-price='$data->price'
                    data-total-price='$data->total_price'
                    data-quantity='$data->quantity'
                    data-status='$data->status'
                    data-type='$data->type'><i class='fa fa-edit'></i></button>";
    }

    /**
     *
     * @param $data
     * @return string
     */
    private function btnArrived($data)
    {
        $trans = trans("$this->trans.arrived");

        $quantity = $data->booking()->sum("quantity");

        if (!$data->is_came)
            return "<span class='btn btn-info btn-arrived' data-id='$data->id' data-quantity='$quantity'>$trans</span>";
    }



}
