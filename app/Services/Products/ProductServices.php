<?php


namespace App\Services\Products;


use App\Models\Product\Product;
use App\Models\Stock;
use App\Models\Supplier\SupplierBill;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use function React\Promise\Stream\first;

class ProductServices extends Product
{


    /**
     * get data collection by query string to filter it
     *
     * @param Request $request
     * @return Builder[]|Collection
     */
    public function sort(Request $request)
    {
        if ($request->cat)
            return $this->byCategory($request->cat);

        if ($request->supplier)
            return $this->bySupplier($request->supplier);

        if ($request->stock)
            return Stock::find($request->stock)->products()->where("products_stocks.quantity","!=",0)->whereNull("products_stocks.deleted_at")->latest()->get();

        return $this->latest()->get();
    }

    /**
     * get record by category id
     *
     * @param $category
     * @return mixed
     */
    public function byCategory($category)
    {
        return $this->where('category_id', $category)->latest()->get();
    }
    
    /**
     * get record by supplier id
     *
     * @param $supplier
     * @return mixed
     */
    public function bySupplier($supplier)
    {
        return $this->where('supplier_id', $supplier)->latest()->get();
    }

    public function expired()
    {
        $date = function ($date){
            return $date;
        };
        return $this->stocks()->where("products_stocks.quantity",">",1)->pluck("products_stocks.expired_at")->map($date);
    }
    
    /**
     * @return mixed
     */
    public function remainingQuantity()
    {
        return $this->stocks()->where("products_stocks.quantity",">",1)->sum("quantity");
    }
    
    /**
     * latest price of product
     *
     * @return int
     */
    public function latestPrice()
    {
        return ($stock = $this->stocks()->latest()->first()) ? $stock->pivot->ton_price : 0;
    }

    /**
     * check if the product is available
     *
     * @param $q
     * @return mixed
     */
    public function availableStocks()
    {
        return $this->stocks()->latest("quantity")->get();
    }


    /**
     * get sale price of product
     *
     * @return mixed
     */
    public function salePrice()
    {
        if ($stock = $this->stocks()->latest()->first()) return $stock->pivot->sale_price;
    }


    public function profit()
    {
        return ($stock = $this->stocks()->latest()->first()) ? $stock->pivot->sale_price - $stock->pivot->piece_price : 0;
    }

    /**
     * create new record with code
     *
     * @param $data
     * @return mixed
     */
    public function createWithCode($data)
    {
        $data = array_merge($data,['code'=> $this->code()]);

        return $this->create($data);
    }



    public function gainLoss($bill)
    {
        $piecePrice = ($stock = $this->productsStocks()->latest()->first()) ? $stock->piece_price : 1;

        $gain = $bill->pivot->price - ($bill->pivot->quantity * $piecePrice);

        $debt = $bill->balances->sum("paid") - $bill->price;

        if ($gain <0 && $debt < 0)
            $data = ['gain'=> 0, 'loss' => ($gain) - ($debt)];
        else if ($debt < 0 && $gain == 0)
            $data = ['gain'=> 0, 'loss' => ($debt)];
        else
            $data = ['gain'=> $gain, 'loss' => $debt];

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

        return mapArray($this->clientBills,$data);
    }

    /**
     * @param $request
     */
    public function updatePrice($request)
    {
        $piece_price = ($weight = $this->weight) ? $request->price / (1000/$weight) : $request->price;

        $this->prices()->create(array_merge($request->all(), ['user_id' => auth()->id()]));


        $this->stocks()->update(array_merge($request->only("sale_price"),['ton_price' => $request->price,'piece_price' => $piece_price]));
    }

    /*
     * reports dates
     */

    public function locationsDate($start = null,$end = null)
    {
        $data = ($start || $end)
            ? $this->clientProduct()->whereBetween("created_at",[startDate($start),endDate($end)])
            : $this->clientProduct();

        return mapArray($data->get(),function ($c,$product) use ($data){
            return $c->put($product->client->address,$data->pluck("created_at")->toArray());
        });
    }

    public function consumptionDate($start = null,$end = null)
    {
        if ($start || $end){
            $quantity = $this->clientProduct()->whereBetween("created_at",[startDate($start),endDate($end)]);
            $returned = $this->clientProductReturn()->whereBetween("created_at",[startDate($start),endDate($end)]);
        } else{
            $quantity = $this->clientProduct();
            $returned = $this->clientProductReturn();
        }

        return collect($quantity->pluck("created_at"))
            ->merge($returned->pluck("created_at"))
            ->map(function ($date){ return $date->format("Y-m-d"); })
            ->unique();
    }

    public function gainLossDate($start = null,$end= null)
    {
        $data = ($start || $end)
            ? $this->clientBills()->whereBetween("bills_clients.created_at",[startDate($start),endDate($end)])
            : $this->clientBills();

        return $data->pluck("bills_clients.created_at")->map(function ($date){
            return date_format(date_create($date),"Y-m-d");
        });
    }

    /*
     * Reports
     */
    public function locationsGraph($start = null,$end= null)
    {
        $callback = function ($c,$dates,$location) use ($start,$end){
            foreach ($dates as $date) {
                $quantity = $this->clientProduct()->whereBetween("created_at", [startDate($date), endDate($date)])->sum("quantity");
                $c->put($location, [$quantity, rand_color(true)]);
            }
            return $c;
        };
        return mapArray($this->locationsDate($start,$end), $callback);
    }

    public function consumptionGraph($start = null,$end = null)
    {
        $callback = function ($c,$date){
            $quantity = $this->clientProduct()->whereBetween("created_at",[startDate($date),endDate($date)])->sum("quantity");
            $return = $this->clientProductReturn()->whereBetween("created_at",[startDate($date),endDate($date)])->sum("quantity");
            $c->put($date,[$quantity,-$return]);
        };
        return mapArray($this->consumptionDate($start,$end),$callback);
    }

    public function pricesGraph($start = null,$end = null)
    {
        $dates = ($start || $end) ? $this->prices()->whereBetween("created_at",[startDate($start),endDate($end)]) : $this->prices();

        $format = function ($date){ return $date->format("Y-m-d"); };

        return mapArray($dates->pluck("created_at")->map($format),function ($c,$date){
            foreach ($this->prices()->whereBetween("created_at",[startDate($date),endDate($date)])->get() as $price)
                $c->put($date,$price->price);
            return $c;
        });
    }


    public function gainLossGraph($start = null,$end = null)
    {
        $data = function ($c,$date){
            foreach ($this->clientBills()->whereBetween("bills_clients.created_at",[startDate($date),endDate($date)])->get() as $bill)
                $c->put($date,$this->gainLoss($bill));
            return $c;
        };
        return mapArray($this->gainLossDate($start,$end),$data);
    }


    public function createOpeningBill($request)
    {
        return !($bill = SupplierBill::where("supplier_id",$request->supplier_id)->first())
             ? (SupplierBill::create([
                'code' => SupplierBill::code(),
                'number' => 1,
                'price' => $request->purchase_price * ($request->weight ? ($request->quantity /(1000/$request->weight)) : 1),
                'quantity', $request->quantity,
                'status' => 'shipped',
                'is_cash' => false,
                'notes' => 'فاتورة الرصيد الافتتاحى',
                'supplier_id' => $request->supplier_id,
                'user_id' => auth()->id()
            ]))->id
            : $bill->id;
    }



}
