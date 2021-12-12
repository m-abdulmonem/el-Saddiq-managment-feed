<?php

namespace App\Observers\Clients;

use App\Models\Client\ClientBillReturn;
use App\Models\Client\ClientProduct;
use App\Models\Product\ProductStock;
use App\Models\Transactions\CatchPurchase;
use App\Models\Transactions\Payments;

class ReturnedInvoicesObServers
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
    public function created(ClientBillReturn $invoices)
    {
        $request = request();
        $balance = $invoices->clientBill()->first()->createBalance($request,"payment");
        Payments::create([
            'code' => Payments::code(),
            'payment' => 'cash',
            'payment_type' => 'expenses',
            'paid' => $request->postpaid,
            'client_bill_id' => $invoices->id,
            'balance_id' => $balance->id,
            'client_id' => $invoices->client_id,
            'user_id' => auth()->id()
        ]);
        $callback = function ($c,$k,$id) use ($request,$invoices){
            $product = ClientProduct::with([])->where([["bill_id",$request->route("invoice")->id],['product_id',$id]])->first();
            $product->quantity != $request->quantity[$k]
                ? $product->decrement("quantity",$request->quantity[$k])
                : $product->delete();
            ProductStock::with([])->increase($id,$request->stock_id[$k],$request->quantity[$k]);
            return $c->put($id,[
                'piece_price'=> $request->unitPrice[$k],
                'quantity' => $request->quantity[$k],
                'stock_id'=> $request->stock_id[$k],
                'client_id'=> $request->client_id,
                'price' => $request->price[$k],
            ]);
        };
        $clientProductsReturn = $invoices->products()->sync(eachData($request->products,$callback)->toArray());
    }
}
