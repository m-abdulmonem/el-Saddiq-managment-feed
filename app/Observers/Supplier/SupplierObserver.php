<?php

namespace App\Observers\Supplier;

use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierBalance;
use App\odal;

class SupplierObserver
{
    /**
     * Handle the supplier "created" event.
     *
     * @param Supplier $supplier
     * @return void
     */
    public function created(Supplier $supplier)
    {

        $request = request();

        $supplier->openBalance()->create([
            'creditor' => $request->creditor,
            'debtor' => $request->debtor,
        ]);

//        $supplier->balance()->create([
//            'opening_balance' => $request->opening_balance,
//            'code' => SupplierBalance::code(),
//            'user_id' => auth()->id(),
//            'type' => null,
//        ]);
    }

    /**
     * Handle the supplier "updated" event.
     *
     * @param Supplier $supplier
     * @return void
     */
    public function updated(Supplier $supplier)
    {
        //
    }

    /**
     * Handle the supplier "deleted" event.
     *
     * @param Supplier $supplier
     * @return void
     */
    public function deleted(Supplier $supplier)
    {
        //
    }

    /**
     * Handle the supplier "restored" event.
     *
     * @param Supplier $supplier
     * @return void
     */
    public function restored(Supplier $supplier)
    {
        //
    }

    /**
     * Handle the supplier "force deleted" event.
     *
     * @param Supplier $supplier
     * @return void
     */
    public function forceDeleted(Supplier $supplier)
    {
        //
    }
}
