<?php

namespace App\Observers\Clients;

use App\ClientBill;
use App\Models\Client\ClientBalance;
use App\Models\ProductStock;
use App\Services\Clients\bills\InvoicesServices;
use Illuminate\Http\Request;

class InvoicesObservers
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {

        $this->request = $request;
    }

    /**
     * Handle the client bill "created" event.
     *
     * @param InvoicesServices $invoices
     * @return void
     */
    public function created(InvoicesServices $invoices)
    {
        $request = request();

        $invoices->createProduct($request);
        $invoices->createBalance($request);
        $invoices->createDiscount($request);
    }

    /**
     * Handle the client bill "updated" event.
     *
     * @param InvoicesServices $invoices
     * @return void
     */
    public function updated(InvoicesServices $invoices)
    {
        $invoices->createProduct($this->request,true);
    }

    /**
     * @param InvoicesServices $invoices
     */
    public function deleting(InvoicesServices $invoices)
    {
        $invoices->remaining() === 0 ? $invoices->products()->delete() : false;
    }

    /**
     * Handle the client bill "deleted" event.
     *
     * @param InvoicesServices $invoices
     * @return void
     */
    public function deleted(InvoicesServices $invoices)
    {

    }

    /**
     * Handle the client bill "restored" event.
     *
     * @param InvoicesServices $invoices
     * @return void
     */
    public function restored(InvoicesServices $invoices)
    {
//        $callback = function ($product,$k){
//            return $product->restore();
//        };
//
//        array_map($callback,$invoices->products);
    }

    /**
     * Handle the client bill "force deleted" event.
     *
     * @param InvoicesServices $clientBill
     * @return void
     */
    public function forceDeleted(InvoicesServices $clientBill)
    {

    }
}
