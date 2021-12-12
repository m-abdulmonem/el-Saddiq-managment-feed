<?php


namespace App\Services\Supplier;

use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierProduct;
use App\Models\Supplier\SupplierProductReturn;
use Illuminate\Support\Collection;

class SupplierServices extends Supplier
{
    /**
     * get latest bill price
     *
     * @return string
     */
    public function balances()
    {
        return currency(($bill = $this->bill()->latest("id")->first()) ? $bill->price : 0);
    }

    /**
     * get debt for supplier
     *
     * @return mixed
     */
    public function debt()
    {
        $paid = $this->balance()->where("type","payment")->sum("paid");
        $price = $this->bill()->sum("price");

        return $paid - $price;
    }

    /**
     * calc creditor supplier
     *
     * @return string
     */
    public function creditor()
    {
        return currency( (($debt = $this->debt()) < 0 ) ? removeMines($debt) : 0 );
    }

    /**
     * calc debtor supplier
     *
     * @return string
     */
    public function debtor()
    {
        return currency( (($debt = $this->debt()) > 0 ) ? $debt : 0 );
    }

    /**
     * get total paid value for supplier
     *
     * @return mixed
     */
    public function totalPaid()
    {
        return $this->balance()->where("type",'payment')->sum("paid");
    }

    /**
     * calc total bills price
     *
     * @return mixed
     */
    public function totalBillsPrice()
    {
        return $this->bill()->sum("price");
    }

    public function openingBalance()
    {
        return ( ( $balance = 500) < 0)
            ? currency(removeMines($balance) + $this->totalBillsPrice())
            : currency($this->totalBillsPrice() - $balance);
    }


    public function courseQuantity()
    {
        return 0;
    }

    /**
     * get latest bill date
     *
     * @return string
     */
    public function latestBill()
    {
        return ($bill = $this->bill()->latest("id")->first())
            ? $bill->created_at->diffForHumans()
            : "-";
    }

    /**
     * get date of purchased products
     *
     * @param null $start
     * @param null $end
     * @return Collection
     */
    public function quantityDate($start = null ,$end = null)
    {
        $collect = collect();
        foreach ($this->bill as $bill){
            $products = ($start || $end)
                ? $bill->products()->whereBetween("products_suppliers.created_at",[startDate($start),endDate($end)])->get()
                : $bill->products;

            foreach ($products as $product)
                $collect->push($product->pivot->created_at->format("Y-m-d"));
        }
        return $collect->unique()->sort();
    }

    /**
     * get date of purchased products
     *
     * @param null $start
     * @param null $end
     * @return Collection
     */
    public function chickQuantityDate($start = null ,$end = null)
    {
        $data = collect();
        foreach ($this->chicks as $chick){

            $chicks = ($start || $end)
                ? $chick->orders()->whereBetween("created_at",[startDate($start),endDate($end)])->pluck("created_at")
                : $chick->orders()->pluck("created_at");

            $data->push($chicks);
        }
        return $data->unique()->sort()->get(0)->map(function ($date){return $date->format("Y-m-d");});
    }

    /**
     * get date  of bills and returned bills
     *
     * @param null $start
     * @param null $end
     * @return mixed
     */
    public function billsDate($start = null ,$end = null)
    {
        if ($start || $end){
            $bills = $this->bill()
                ->whereBetween("created_at",[startDate($start),endDate($end)])
                ->pluck("created_at")->toArray();
            $return = $this->returnBill()
                ->whereBetween("created_at",[startDate($start),endDate($end)])
                ->pluck("created_at")->toArray();
        }else {
            $bills = $this->bill()->pluck("created_at")->toArray();
            $return = $this->returnBill()->pluck("created_at")->toArray();
        }
        $format = function ($v,$k){
            return $v->format("Y-m-d");
        };

        return collect($bills)->merge($return)->map($format)->unique()->sort();
    }

    /**
     * get purchased products ids
     *
     * @return array
     */
    public function productsIds()
    {
        $data = collect();
        foreach ($this->bill as $bill){
            foreach ($bill->products as $product)
                $data->put($product->name(),$product->pivot->product_id);
        }
        return $data->unique()->toArray();
    }

    /**
     * get quantity of products and returned products
     *
     * @param null $start
     * @param null $end
     * @return array
     */
    public function quantityGraph($start = null,$end = null)
    {
        $data = [];
        foreach ($this->quantityDate($start,$end) as $date){

            $quantity =  SupplierProduct::whereIn("bill_id",$this->bill()->pluck("id")->toArray())
                ->whereBetween("created_at",[startDate($date),endDate($date)])->sum("quantity");

            $returned = SupplierProductReturn::whereIn("bill_id",$this->bill()->pluck("id")->toArray())
                ->whereBetween("created_at",[startDate($date),endDate($date)])->sum("quantity");

            $data[$date]=[$quantity,$returned];
        }
        return $data;
    }

    /**
     * get bills and returned bills count of supplier by dates
     *
     * @param null $start
     * @param null $end
     * @return array
     */
    public function billsGraph($start = null,$end = null)
    {
        $data = [];
        foreach ($this->billsDate($start,$end) as $date){
            $quantity = $this->bill()->whereBetween("created_at",[startDate($date),endDate($date)]);

            $returned = $this->returnBill()->whereBetween("created_at",[startDate($date),endDate($date)]);

            $data[$date]=[$quantity->count(),$returned->count()];
        }
        return $data;
    }

    /**
     * get most used products of clients
     *
     * @param null $start
     * @param null $end
     * @return array
     */
    public function productsGraph($start=null,$end=null)
    {
        $data = [];
        foreach ($this->productsIds() as $name => $id){

            $product = SupplierProduct::where("product_id",$id);

            $quantity = ($start || $end)
                ? $product->whereBetween("created_at",[startDate($start),endDate($end)])
                : $product;

            $data[$name] =[$quantity->sum("quantity"),rand_color(true)];
        }
        return $data;
    }

    /**
     * get chicks quantity graph
     *
     * @param null $start
     * @param null $end
     * @return array
     */
    public function chicksQuantityGraph($start = null,$end = null)
    {
        $data = collect();
        foreach ($this->chickQuantityDate($start,$end) as $date){
            foreach ($this->chicks as $chick){
                $quantity = $chick->orders()
                    ->whereBetween("created_at",[startDate($date),endDate($date)])
                    ->sum("quantity");
                $data->push([$date,$quantity]);
            }
        }
        return $data->unique(0);
    }

    /**
     * get most wanted chicks  graph
     *
     * @param null $start
     * @param null $end
     * @return array
     */
    public function chicksGraph($start = null,$end = null)
    {
        $data = [];
        foreach ($this->chicks as $chick){

            $orders = ($start || $end)
                ? $chick->orders()->whereBetween("created_at",[startDate($start),endDate($end)])
                : $chick->orders();

            $data[$chick->name] =[$orders->sum("quantity"),rand_color(true)];
        }
        return $data;
    }

    /**
     * get count of chicks orders graph
     *
     * @param null $start
     * @param null $end
     * @return Collection
     */
    public function ordersGraph($start = null,$end = null)
    {
        $data = collect();

        foreach ($this->chickQuantityDate($start,$end) as $date){
            foreach ($this->chicks as $chick){
                $orders = $chick->orders()->where("is_came",true)
                    ->whereBetween("created_at",[startDate($date),endDate($date)])
                    ->count();
                $data->push([$date,$orders]);
            }
        }

        return $data->unique(0);
    }

    /**
     * get the gain and loss of bills
     *
     * @param null $start
     * @param null $end
     * @return Collection
     * @throws \Exception
     */
    public function billsIncome($start = null,$end = null)
    {
        $collect = collect();
        $dates = [];
        foreach ($this->products as $product){
            foreach ($product->clientBills->pluck("created_at") as $date)
                $dates[] = $date;
        }

        foreach ($dates as $date){

            foreach ($this->products as $product){
                $bills = ($start || $end)
                    ? $product->clientBills()->whereBetween("bills_clients.created_at",[startDate($start),endDate($end)])->get()
                    : $product->clientBills()->whereBetween("bills_clients.created_at",[startDate($date),endDate($date)])->get();

                foreach ($bills as $bill){

                    $gain = $bill->pivot->price - ($bill->pivot->quantity * $product->productsStocks()->latest()->first()->piece_price);

                    $debt = $bill->balances->sum("paid") - $bill->price;

                    if ($gain <0 && $debt < 0)
                        $data = ['gain'=> 0, 'loss' => ($gain) - ($debt)];
                    else if ($debt < 0 && $gain == 0)
                        $data = ['gain'=> 0, 'loss' => ($debt)];
                    else
                        $data = ['gain'=> $gain, 'loss' => $debt];

                    $collect->put(carbon($date)->format("Y-m-d"), $data);
                }
            }
        }
        return $collect;
    }

    /**
     * get the gain and loss of chicks orders  graph
     *
     * @param null $start
     * @param null $end
     * @return Collection
     * @throws \Exception
     */
    public function ordersIncome($start=null,$end=null)
    {
        $collect = collect();
        $dates = [];
        foreach ($this->chicks as $chick){
            foreach ($chick->orders()->pluck("created_at") as $date)
                $dates[] = $date;
        }

        foreach ($dates as $date){
            foreach ($this->chicks as $chick){

                ($start || $end)
                    ? $orders = $chick->orders()->where("is_came",true)->whereBetween("created_at",[startDate($start),endDate($end)])->get()
                    : $orders = $chick->orders()->where("is_came",true)->whereBetween("created_at",[startDate($date),endDate($date)])->get();

                foreach ($orders as $order){

                    foreach ($order->booking()->where("is_came",true)->get() as $booking) {

                        $gain = ( ($order->chick_price *$booking->quantity) - ($order->price / $order->quantity) * $booking->quantity);
                        $debt = $booking->balances->sum("paid") - ($booking->quantity * $order->chick_price);

                        if ($gain <0 && $debt < 0)
                            $data = ['gain'=> 0, 'loss' => ($gain) - ($debt)];
                        else if ($debt < 0 && $gain == 0)
                            $data = ['gain'=> 0, 'loss' => ($debt)];
                        else
                            $data = ['gain'=> $gain, 'loss' => ($debt)];

                        $collect->put(carbon($date)->format("Y-m-d"), $data);
                    }

                }

            }
        }

        return $collect;
    }

    /**
     * get chicks orders and bills gain and loss
     *
     * @param null $start
     * @param null $end
     * @return Collection
     * @throws \Exception
     */
    public function incomeStatementGraph($start = null,$end = null)
    {
        return $this->billsIncome(null,$start,$end)
            ->merge($this->ordersIncome($start,$end))->sort();
    }

    /**
     * create new record with code
     *
     * @param $data
     * @return mixed
     */
    public function createCode($data)
    {
        return $this->create(array_merge($data,['code' => $this->count() +1 ]));
    }
    
}
