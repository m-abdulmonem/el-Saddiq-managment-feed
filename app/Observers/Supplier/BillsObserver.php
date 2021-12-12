<?php

namespace App\Observers\Supplier;

use App\Models\Price;
use App\Models\Supplier\SupplierBill;
use App\Services\Supplier\Bills\BillServices;
use Illuminate\Http\Request;

class BillsObserver
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
     * Handle the supplier bill "created" event.
     *
     * @param  \App\Models\Supplier\SupplierBill  $supplierBill
     * @return void
     */
    public function creating(SupplierBill $supplierBill)
    {
        //
    }

    /**
     * Handle the supplier bill "created" event.
     *
     * @param BillServices $bill
     * @return void
     */
    public function created(BillServices $bill)
    {
//        $quantity = 0;
//        foreach ($this->request->product_id as $k=>$v){
//
//            $quantity += $this->request->quantity[$k];
//
//            $bill->createPrice($this->request,$k,$v);
//
//            $bill->createStock($this->request,$k,$v);
//        }

        $bill->syncProductSupplier($this->request);

        $bill->createBalances($this->request);

//        $bill->updateQuantity($quantity);
    }

    /**
     * Handle the supplier bill "updated" event.
     *
     * @param BillServices $bill
     * @return void
     * @throws \Exception
     */
    public function updated(BillServices $bill)
    {
        if (!$this->request->is_returned){
            $quantity = 0;
            foreach ($this->request->product_id as $k=>$v){
                $quantity += $this->request->quantity[$k];
                ($price = $bill->price($v)) ? $price->price : null;
                if ($this->request->prices[$k] !== $price)
                    $bill->createPrice($this->request,$k,$v);
            }
            $bill->syncProductSupplier($this->request);
            $bill->syncStock($this->request);
            $bill->updateQuantity($quantity);
        }
    }

    /**
     * Handle the supplier bill "deleted" event.
     *
     * @param BillServices $bill
     * @return void
     */
    public function deleted(BillServices $bill)
    {
        if (( (($bill->price - $bill->discount) - $bill->balances()->sum("paid")) === 0))
            $bill->products()->delete();
    }

    /**
     * Handle the supplier bill "restored" event.
     *
     * @param  \App\Models\Supplier\SupplierBill  $supplierBill
     * @return void
     */
    public function restored(SupplierBill $supplierBill)
    {
        //
    }

    /**
     * Handle the supplier bill "force deleted" event.
     *
     * @param  \App\Models\Supplier\SupplierBill  $supplierBill
     * @return void
     */
    public function forceDeleted(SupplierBill $supplierBill)
    {
        //
    }
}
