<?php


namespace App\Services\Balances;


use App\Models\Chick\ChickOrder;
use App\Models\Supplier\SupplierBalance;

class SupplierServices
{

    /**
     * @var SupplierBalance
     */
    private $balance;
    /**
     * @var ChickOrder
     */
    private $order;

    public function __construct(SupplierBalance $balance,ChickOrder $order)
    {
        $this->balance = $balance;
        $this->order = $order;
    }


    /**
     * @param $request
     * @param $id
     * @return mixed|void
     */
    public function sort($request,$id)
    {
        if ($request->type)
            return $this->byType($request->type,$id);

        elseif ($request->start||$request->end)
            return $this->byDate($request->start,$request->end,$id);
        
        else
            return $this->byOrder($id)->latest()->get();
    }

    /**
     * get all chick orders record
     *
     * @param $id
     * @param $request
     * @return mixed
     */
    public function byOrders($id,$request)
    {
        $ordersIds = ChickOrder::where("chick_id",$id)->pluck("id");

        $balances = $this->balance->whereIn("order_id",$ordersIds);

        if ($request->start|| $request->end)
            return $balances->whereBetween("created_at",[startDate($request->start),endDate($request->end)])->get();

        elseif ($request->type)
            return $balances->where("type",$request->type)->get();
        else
            return  $balances->get();
    }

    /**
     * get all record has this order [$id]
     *
     * @param int $id
     * @return mixed
     */
    public function byOrder(int $id)
    {
        return $this->balance->where("order_id",$id);
    }

    /**
     * get all record has this [$type]
     *
     * @param string $type
     * @param $id
     * @return mixed
     */
    public function byType(string $type,$id)
    {
        return $this->byOrder($id)->where("type",$type)->latest()->get();
    }

    /**
     * get all record between [start] and [end] date
     *
     * @param $start
     * @param $end
     * @param $id
     * @return mixed
     */
    public function byDate($start,$end,$id)
    {
        return $this->byOrder($id)->whereBetween("created_at",[startDate($start),endDate($end)])->latest()->get();
    }

    /**
     * get all remaining balance
     *
     * @param $order
     * @return mixed
     */
    public function remaining($order)
    {
        return $this->byOrder($order->id)->where("supplier_id",$order->chick->supplier_id)->sum("remaining_amount");
    }

    public function totalPaid($id)
    {
        $callback = function ($order){
            return $this->paid($order);
        };

        return $this->order->where("chick_id",$id)->get()->map($callback)->sum();
    }


    public function totalCreditor($id)
    {
        $callback = function ($order){
            return $this->creditor($order);
        };

        return $this->order->where("chick_id",$id)->get()->map($callback)->sum();
    }

    public function totalDebtor($id)
    {
        $callback = function ($order){
            return $this->debtor($order);
        };

        return $this->order->where("chick_id",$id)->get()->map($callback)->sum();
    }
    
    /**
     * get all paid
     *
     * @param $order
     * @return mixed
     */
    public function paid($order)
    {
        return $this->byOrder($order->id)->where("supplier_id",$order->chick->supplier_id)->where("type","payment")->sum("paid");
    }

    /**
     * get total creditor
     *
     * @param $order
     * @return mixed
     */
    public function creditor($order)
    {
        if (($creditor = $order->price - $this->paid($order)) > 0)
            return $creditor;
    }

    /**
     * get total debtor
     *
     * @param $order
     * @return int
     */
    public function debtor($order)
    {
        if (( $debtor = $order->price - $this->paid($order)) < 0)
            return removeMines($debtor);
    }
    
}
