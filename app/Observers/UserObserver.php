<?php

namespace App\Observers;


use App\Models\ChickOrder;

class UserObserver
{
    /**
     * Handle the chick order "created" event.
     *
     * @param  ChickOrder  $chickOrder
     * @return void
     */
    public function created(ChickOrder $chickOrder)
    {
        jsonSuccess(trans("home.alert_success_create", ['name' => ''] )  );
    }

    /**
     * Handle the chick order "updated" event.
     *
     * @param  ChickOrder  $chickOrder
     * @return void
     */
    public function updated(ChickOrder $chickOrder)
    {
        //
    }

    /**
     * Handle the chick order "deleted" event.
     *
     * @param  ChickOrder  $chickOrder
     * @return void
     */
    public function deleted(ChickOrder $chickOrder)
    {
        //
    }

    /**
     * Handle the chick order "restored" event.
     *
     * @param  ChickOrder  $chickOrder
     * @return void
     */
    public function restored(ChickOrder $chickOrder)
    {
        //
    }

    /**
     * Handle the chick order "force deleted" event.
     *
     * @param  ChickOrder  $chickOrder
     * @return void
     */
    public function forceDeleted(ChickOrder $chickOrder)
    {
        //
    }
}
