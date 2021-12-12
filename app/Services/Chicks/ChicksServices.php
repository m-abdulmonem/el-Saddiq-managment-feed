<?php


namespace App\Services\Chicks;

use App\Models\Chick\Chick;
use App\Models\Chick\ChickOrder;
use App\Services\Balances\ClientServices;
use App\Services\Balances\SupplierServices;
use App\Services\Clients\ClientsServices;

class ChicksServices extends Chick
{

    /**
     * @var ClientServices
     */
    private $clientServices;
    /**
     * @var SupplierServices
     */
    private $supplierServices;

    /**
     * ChicksServices constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->clientServices = new ClientsServices();

        parent::__construct($attributes);
    }

    public function sort($request)
    {
        if ($request->suplpier)
            return $this->where("supplier",$request->supplier)->latest()->get();
        else
            return $this->byType($request->type);
    }

    /**
     * @param $type
     * @return mixed
     */
    public function byType($type)
    {
        return $type ? $this->where("type",$type)->latest()->get() : $this->latest()->get();
    }

    /**
     * get creditor and gain value of orders and booking
     *
     * @return mixed
     */
    public function creditor()
    {
        $callback = function ($collect,$order){
            return $collect->push($this->clientServices->creditor($order));
        };


        return mapArray($this->orders,$callback)->sum();
    }

    /**
     * get debtor and loss value of orders and booking
     *
     * @return mixed
     */
    public function debtor()
    {
        $callback = function ($collect,$v){
            return $collect->push($this->clientServices->debtor($v));
        };

        return mapArray($this->orders,$callback)->sum();
    }

    /**
     * calculate all booking quantity
     *
     * @return mixed
     */
    public function quantity()
    {
        $callback = function ($collect,$v){
            return $collect->push($v->booking()->sum("quantity"));
        };

        return mapArray($this->orders,$callback)->sum();
    }

    /**
     * get chick price statics graph
     *
     * @param $request
     * @return array
     */
    public function pricesStatics($request)
    {
        $prices = ($request->start || $request->end)
            ? $this->prices()->whereBetween("created_at" ,[ startDate($request->start),endDate($request->end) ])->get()
            : $this->prices;

        $data = function ($collect,$data){
            return $collect->put($data->created_at->format("Y-m-d"),$data->price);
        };

        return mapArray($prices,$data)->toArray();
    }

    /**
     * get locations statics graph
     *
     * @param $request
     * @param $id
     * @return array
     */
    public function locationsStatics($request)
    {

        $orders = ($request->start || $request->end)
            ? $this->orders()->whereBetween("created_at" ,[ startDate($request->start),endDate($request->end) ])->get()
            : $this->orders;

        $locations = function ($collect,$data) {
            foreach ($data->booking as $booking)
                $collect->put($booking->client->address,$data->booking->sum("quantity"));

            return $collect;
        };

        return mapArray($orders,$locations)->toArray();
    }

    /**
     * get consumption dates
     *
     * @param $request
     * @return \Illuminate\Support\Collection
     */
    public function consumptionDates($request)
    {
        $dates = ($request->start || $request->end)
            ? $this->orders()->whereBetween("created_at",[startDate($request->start),endDate($request->end)])
            :   $this->orders();

        return $dates->pluck("created_at")->map(function ($date){return $date->format("Y-m-d");})->unique();
    }

    /**
     * get consumption dates and quantity
     *
     * @param $request
     * @return \Illuminate\Support\Collection
     */
    public function consumptionGraph($request)
    {
        $data = function ($c,$date){
            $orders = $this->orders()->whereBetween("created_at",[startDate($date), endDate($date)])->sum("quantity");
            return $c->put($date,$orders);
        };

        return mapArray($this->consumptionDates($request),$data);
    }

    /**
     * @param $request
     * @return \Illuminate\Support\Collection
     */
    public function debtDates($request)
    {
        $data = function ($c,$order) use ($request){
            $data = ($request->start || $request->end)
                ? $order->bookign()->whereBetween("created_at",[startDate($request->start),endDate($request->end)])
                : $order->booking();

            return $c->push($data->pluck("created_at")->map(function ($date){return $date->format("Y-m-d");})->unique());
        };
        $collect = collect();
        foreach (mapArray($this->orders()->where("is_came",true)->get(),$data) as $dates){
            foreach ($dates as $date)
                $collect->push($date);
        }
        return $collect;
    }

    /**
     * @param $request
     * @return \Illuminate\Support\Collection
     */
    public function debtGraph($request)
    {
        $collect = collect();
        foreach ($this->debtDates($request) as  $date){
            foreach ($this->orders()->where("is_came",true)->get() as $order){

                $data =  $order->booking()->where("is_came",true)
                    ->whereBetween("created_at",[startDate($date),endDate($date)])->get();

                foreach ($data as $booking)
                    $collect->put($date, $this->calcGainLoss($order,$booking));

            }
        }
        return $collect;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function debt()
    {
        $collect = collect();
        foreach ($this->orders()->where("is_came",true)->get() as $order){
            foreach ( $order->booking()->where("is_came",true)->get() as $booking) {

                $collect->push( $this->calcGainLoss($order,$booking));
            }
        }
        return $collect;
    }

    /**
     * @param $order
     * @param $booking
     * @return array
     */
    public function calcGainLoss($order,$booking)
    {
        $gain = ( ($order->chick_price *$booking->quantity) - ($order->price / $order->quantity) * $booking->quantity);
        $debt = $booking->balances->sum("paid") - ($booking->quantity * $order->chick_price);

        if ($gain <0 && $debt < 0)
            $data = ['gain'=> 0, 'loss' => ($gain) - ($debt)];
        else if ($debt < 0 && $gain == 0)
            $data = ['gain'=> 0, 'loss' => ($debt)];
        else
            $data = ['gain'=> $gain, 'loss' => ($debt)];

        return $data;
    }

    /**
     * @param $request
     * @return \Illuminate\Support\Collection
     */
    public function supplierBalances($request)
    {
        $balances = collect();
        foreach ($this->orders as $order) {
            if ($request->start || $request->end)
                $data = $order->balances()->whereBetween("created_at",[startDate($request->startDate),endDate($request->end)])->latest()->get();
            elseif ($type = $request->type)
                $data = $order->balances()->where("type",$type)->latest()->get();
            else
                $data = $order->balances()->latest()->get();

            $balances->push($data);
        }
        $transactions = collect();

        foreach ($balances as $balance)
            foreach ($balance as $transaction)
                $transactions->push($transaction);

        return $transactions;
    }

    /**
     * @param $request
     * @return \Illuminate\Support\Collection
     */
    public function clientBalances($request)
    {
        $balances = collect();
        foreach ($this->orders as $order) {
            foreach ($order->booking as $booking){
                if ($request->start || $request->end)
                    $data = $booking->balances()->whereBetween("created_at",[startDate($request->startDate),endDate($request->end)])->latest()->get();
                elseif ($type = $request->type)
                    $data = $booking->balances()->where("type",$type)->latest()->get();
                else
                    $data = $booking->balances()->latest()->get();

                $balances->push($data);
            }
        }
        $transactions = collect();
        foreach ($balances as $data){
            foreach ($data as $balance)
                $transactions->push($balance);

        }
        return $transactions;
    }

    /**
     * get total paid of supplier
     *
     * @return mixed
     */
    public function supplierPaid()
    {
        $data = function ($c,$order){ return $c->push($order->balances()->sum("paid")); };

        return mapArray($this->orders,$data)->sum();
    }

    /**
     * get suppliers debt
     *
     * @return mixed
     */
    public function supplierDebt()
    {
        return $this->supplierPaid() - $this->orders()->sum("price");
    }

    /**
     * get creditor suppliers
     *
     * @return int
     */
    public function creditorSupplier()
    {
        return ( ($debt = $this->supplierDebt() < 0) ) ? removeMines($debt) : 0;
    }

    /**
     * get debtor suppliers
     *
     * @return bool|int
     */
    public function debtorSupplier()
    {
        return ( ($debt = $this->supplierDebt() > 0) ) ? $debt : 0;
    }

    /**
     * get total paid od clients
     *
     * @return mixed
     */
    public function clientPaid()
    {
        $data = function ($c,$order){
            foreach ($order->booking as $booking)
                $c->push($booking->balances()->sum("paid"));

            return $c;
        };

        return mapArray($this->orders,$data)->sum();
    }

    /**
     * get total price of clients booking
     *
     * @return mixed
     */
    public function bookingTotalPrice()
    {
        $data = function ($c,$order){
            foreach ($order->booking()->where("is_came",true)->get() as $booking)
                $c->push($booking->quantity * $order->chick_price);
            return $c;
        };
        return mapArray($this->orders()->where("is_came",true)->get(),$data)->sum();
    }

    /**
     * get clients debt
     *
     * @return mixed
     */
    public function clientDebt()
    {
        return $this->clientPaid() - $this->bookingTotalPrice();
    }

    /**
     * get debtor clients
     *
     * @return int
     */
    public function debtorClient()
    {
        return (($debt = $this->clientDebt()) < 0) ? removeMines($debt) : 0;
    }

    /**
     * get creditor clients
     *
     * @return int|mixed
     */
    public function creditorClient()
    {
        return (($debt = $this->clientDebt()) > 0) ? $debt : 0;
    }



    
    /**
     * get sold quantity
     *
     * @return mixed
     */
    public function soldQuantity()
    {
        return $this->orders()->where("is_came",true)->sum("quantity");
    }

    /**
     * get unsold quantity
     * @return mixed
     */
    public function unsoldQuantity()
    {
        return $this->orders()->sum("quantity") - $this->soldQuantity();
    }

    public function client()
    {
        return $this->clientServices;
    }

}
