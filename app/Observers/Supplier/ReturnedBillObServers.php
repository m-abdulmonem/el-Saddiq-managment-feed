<?php

namespace App\Observers\Supplier;

use App\Models\Client\ClientProduct;
use App\Models\Product\ProductStock;
use App\Models\Supplier\SupplierBillReturn;
use App\Models\Supplier\SupplierProduct;

class ReturnedBillObServers
{
    public function __construct()
    {
    }

    /**
     * Handle the client bill "created" event.
     *
     * @param ClientBillReturn $invoices
     * @return void
     */
    public function created(SupplierBillReturn $invoices)
    {
        $request = request();

        $callback = function ($c,$k,$id) use ($request,$invoices){
            $product = SupplierProduct::with([])->where([["bill_id",$request->route("bill")->id],['product_id',$id]])->first();

            $product->quantity != $request->quantity[$k] ? $product->decrement("quantity",$request->quantity[$k]) : $product->delete();

            $count = $product->weight ? ((1000/$product->weight) * $request->quantity[$k]) : $request->quautity[$k];

            ProductStock::with([])->decrease($id,$request->stock[$k],$count);

            return $c->push($id,[
                'quantity' => $request->quantity[$k],
                'price' => $request->prices[$k],
                'piece_price' => $this->calcPiecePrice($request->prices[$k],$request->quantity[$k],$id),
                'user_id' => auth()->id()
            ]);
        };

        $invoices->decrement("quantity",$request->tQuantity);
        $clientProductsReturn = $invoices->products()->sync(eachData($request->product_id,$callback)->toArray());
    }
}
