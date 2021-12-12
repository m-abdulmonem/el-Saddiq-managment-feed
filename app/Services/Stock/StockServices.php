<?php


namespace App\Services\Stock;

use App\Models\Client\ClientBill;
use App\Models\Product\ProductStock;
use App\Models\Stock;

class StockServices extends Stock
{


    /*
     * reports dates
     */

    public function consumptionDate($start = null,$end = null)
    {
        if ($start || $end){
            $quantity = $this->clientProducts()->whereBetween("created_at",[startDate($start),endDate($end)]);
            $returned = $this->clientProductsReturn()->whereBetween("created_at",[startDate($start),endDate($end)]);
        } else{
            $quantity = $this->clientProducts();
            $returned = $this->clientProductsReturn();
        }

        return collect($quantity->pluck("created_at"))
            ->merge($returned->pluck("created_at"))
            ->map(function ($date){ return $date->format("Y-m-d"); })
            ->unique();
    }

    public function productsDate($start = null,$end = null)
    {
        $data = ($start || $end)
            ? $this->clientProducts()->whereBetween("created_at",[startDate($start),endDate($end)])
            : $this->clientProducts();

        return mapArray($data->get(),function ($c,$product) use ($data){
            return $c->put($product->product->name(),$data->pluck("created_at")->map(function ($date){return $date->format("Y-m-d");})->unique()->toArray());
        });
    }
    public function locationsDate($start = null,$end = null)
    {
        $data = ($start || $end)
            ? $this->clientProducts()->whereBetween("created_at",[startDate($start),endDate($end)])
            : $this->clientProducts();

        return mapArray($data->get(),function ($c,$product) use ($data){
            $format = function ($date){
                return $date->format("Y-m-d");
            };
            return $c->put($product->client->address,$data->pluck("created_at")->map($format)->toArray());
        });
    }


    /*
     * Reports
     */

    public function consumptionGraph($start = null,$end = null)
    {
        $callback = function ($c,$date){
            $quantity = $this->clientProducts()->whereBetween("created_at",[startDate($date),endDate($date)])->sum("quantity");
            $return = $this->clientProductsReturn()->whereBetween("created_at",[startDate($date),endDate($date)])->sum("quantity");
            $c->put($date,[$quantity,-$return]);
        };
        return mapArray($this->consumptionDate($start,$end),$callback);
    }

    public function productsGraph($start = null,$end = null)
    {
        $callback = function ($c,$dates,$name) use ($start,$end){
            foreach ($dates as $date) {
                $quantity = $this->clientProducts()->whereBetween("created_at", [startDate($date), endDate($date)])->sum("quantity");
                $c->put($name, [$quantity, rand_color(true)]);
            }
            return $c;
        };
        return mapArray($this->productsDate($start,$end), $callback);
    }

    public function locationsGraph($start = null,$end= null)
    {
        $callback = function ($c,$dates,$location) use ($start,$end){
            foreach ($dates as $date) {
                $quantity = $this->clientProducts()->whereBetween("created_at", [startDate($date), endDate($date)])->sum("quantity");
                $c->put($location, [$quantity, rand_color(true)]);
            }
            return $c;
        };
        return mapArray($this->locationsDate($start,$end), $callback)->toArray();
    }


    /**
     * @return mixed
     */
    public function remainingQuantity()
    {
        return $this->productsStocks()->where("products_stocks.quantity",">",1)->sum("quantity");
    }

    public function expired()
    {
        $data = [];
        $ex = (ProductStock::pluck("expired_at","id")->map(function ($date){ return $date->format("Y-m-d");}));

        foreach ($ex as $key =>$date)
            if ( now()->diffInDays($date) <= 25)
                $data[] = $key;

        return ProductStock::find($data)->sum("quantity");
    }

    public function gainLoss($bill)
    {
        $data = [];
        foreach ($bill->products as $product){
            $piecePrice = ($stock = $this->productsStocks()->latest()->first()) ? $stock->piece_price : 1;

            $gain = $product->pivot->price - ($product->pivot->quantity * $piecePrice);

            $debt = $bill->balances->sum("paid") - $bill->price;

            if ($gain <0 && $debt < 0)
                $data = ['gain'=> 0, 'loss' => ($gain) - ($debt)];
            else if ($debt < 0 && $gain == 0)
                $data = ['gain'=> 0, 'loss' => ($debt)];
            else
                $data = ['gain'=> $gain, 'loss' => $debt];
        }

        return $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function debt()
    {
        $data = function ($c,$bill){
            return $c->push($this->gainLoss($bill));
        };

        return mapArray(ClientBill::with(['products'])->find($this->clientProducts()->pluck("bill_id")->toArray()),$data);

    }

//    public function stock()
//    {
//        $this->products()->where("products_stocks.quantity","!=",0)->whereNull("products_stocks.deleted_at")->get();
//    }

    /**
     * create new record with unique code
     *
     * @param $data
     * @return mixed
     */
    public function createWithCode($data)
    {
        $data = $this->create( array_merge($data,['code'=>$this->code()]) );

        $text = trans("home.alert_success_create",['name' => $data->name ]);

        return jsonSuccess($text,$data);
    }

//    /**
//     * count records to get instance code
//     *
//     * @return int
//     */
//    public function code()
//    {
//        return $this->all()->count() + 1;
//    }
}
