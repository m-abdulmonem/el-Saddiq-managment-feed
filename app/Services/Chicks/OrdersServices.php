<?php


namespace App\Services\Chicks;


use App\Models\Chick\ChickOrder;
use App\Services\Balances\ClientServices;
use App\Services\Balances\SupplierServices;
use App\Services\Sms\SmsServices;

class OrdersServices extends ChickOrder
{

    /**
     * @var ChickOrder
     */
    private $order;
    /**
     * @var SmsServices
     */
    private $sms;
    /**
     * @var SupplierServices
     */
    private $supplierServices;
    /**
     * @var ClientServices
     */
    private $clientServices;


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->sms = new  SmsServices();
    }

    public function byUser($id)
    {
        return $this->where("user_id",$id)->get();
    }

    public function byChick($id)
    {
        return $this->where("chick_id",$id)->latest()->get();
    }
    
    /**
     * get all orders which has status
     *
     * @param $status
     * @return mixed
     */
    public function byStatus($status)
    {
        return ($status) ? $this->where("is_came",$status)->latest()->get() : $this->latest()->get();
    }
    
    
    /**
     * @param bookingServices $bookingServices
     */
    public function arriveConfirm(bookingServices $bookingServices)
    {
        foreach ($this->booking as $booking)
            if ($bookingServices->isOrderArrive())
                $booking->smsDeliveredDate($this->sms);
    }

    /**
     * @return
     */
    public function smsRequestOrder()
    {
        $text = trans("chicks/orders.sms_request_order",['quantity' => $this->quantity,'name'=>$this->chick->name]);

        return $this->sms->createSupplierSms(nexmo($this->phone,$text),$this->chick->supplier->name);
    }


    /**
     * send sms when order be arrived
     *
     * @param $data instance of client model
     * @return
     */
    public function smsArrived($data)
    {
        $sms = nexmo($data->phone,trans("chicks/orders.sms_arrived"));

        return $this->sms->createClientSms($sms,$data->id);
    }



    /**
     * @param $phone
     * @param $date
     * @param $id
     * @return mixed
     */
    public function smsArriveDate($phone,$date,$id)
    {
        $sms = nexmo($phone,trans("chicks/order.arrive_date",['date'=>$date]));

        return $this->sms->createClientSms($sms,$id);
    }

    /**
     * @param $order
     * @param $date
     */
    public function handelArriveDateClientId($order,$date)
    {
        foreach ($order->booking as $booking)
            $this->smsArriveDate($booking->client->phone,$date,$booking->client_id);
    }
    
    /**
     * @param ChickOrder $order
     * @param $date
     * @return bool
     */
    public function arriveAt(ChickOrder $order,$date)
    {
        return $order->update([
            "arrived_at" => $date
        ]);

        $this->handelArriveDateClientId($order,$date);
    }

    /**
     * get gain loss of order
     *
     * @return \Illuminate\Support\Collection
     */
    public function debt()
    {
        $collect = collect();
        foreach ($this->booking()->where("is_came",true)->get() as $booking) {

            $gain = ( ($this->chick_price *$booking->quantity) - ($this->price / $this->quantity) * $booking->quantity);
            $debt = $booking->balances->sum("paid") - ($booking->quantity * $this->chick_price);

            if ($gain <0 && $debt < 0)
                $data = ['gain'=> 0, 'loss' => ($gain) - ($debt)];
            else if ($debt < 0 && $gain == 0)
                $data = ['gain'=> 0, 'loss' => ($debt)];
            else
                $data = ['gain'=> $gain, 'loss' => ($debt)];

            $collect->push( $data);
        }
        return $collect;
    }

    /**
     * get supplier debt
     *
     * @return mixed
     */
    public function supplierDebt()
    {
        return $this->balances()->sum("paid") - $this->price;
    }

    /**
     * get creditor supplier
     *
     * @return int
     */
    public function creditorSupplier()
    {
        return (($debt = $this->supplierDebt()) < 0) ? removeMines($debt) : 0;
    }

    /**
     * get debtor supplier
     *
     * @return int
     */
    public function debtorSupplier()
    {
        return (($debt = $this->supplierDebt()) > 0) ? ($debt) : 0;
    }

    /**
     * get client debt
     *
     * @return float|int|mixed
     */
    public function clientDebt()
    {
        return $this->clientPaid()->sum() - ($this->chick_price * $this->booking()->sum("quantity"));
    }

    /**
     * get creditor client
     *
     * @return float|int|mixed
     */
    public function creditorClient()
    {
        return ( ($debt= $this->clientDebt()) > 0) ? $debt : 0;
    }

    /**
     * get debtor client
     *
     * @return int
     */
    public function debtorClient()
    {
        return ( ($debt= $this->clientDebt()) < 0) ? removeMines($debt) : 0;
    }

    /**
     * format arrive at date
     *
     * @return string
     */
    public function arriveAtFormat()
    {
        return ($date = $this->arrive_at) ? $date->format("Y-m-d") : "-";
    }

    /**
     * get total paid of clients
     *
     * @return \Illuminate\Support\Collection
     */
    public function clientPaid()
    {
        $balances = collect();

        foreach ($this->booking as $booking)
            $balances->push($booking->balances()->sum("paid"));

        return $balances;
    }

    public function clientBalances($request)
    {
        $balances = collect();
        $data = [];
        foreach ($this->booking as $booking){
            if ($request->startDate || $request->end)
                $data = $booking->balances()->whereBetween("created_at",[startDate($request->startDate),endDate($request->end)])->latest()->get();
            elseif ($type = $request->type)
                $data = $booking->balances()->where("type",$type)->latest()->get();
            else
                $data = $booking->balances()->latest()->get();

            $balances->push($data);
        }

        foreach ($balances as $balance){
            foreach ($balance as $transaction){
                $data[] = $transaction;
            }
        }

        return $data;
    }

    /**
     * get sold quantity
     *
     * @return mixed
     */
    public function soldQuantity()
    {
        return $this->booking()->where("is_came",true)->sum("quantity");
    }

    /**
     * get unsold quantity
     *
     * @return mixed
     */
    public function unsoldQuantity()
    {
        return $this->booking()->sum("quantity") - $this->soldQuantity();
    }
    

    /**
     * instance
     *
     * @return SupplierServices
     */
    public function supplierStatics()
    {
        return $this->supplierServices;
    }

    /**
     * @return ClientServices
     */
    public function clientStatics()
    {
        return $this->clientServices;
    }
}
