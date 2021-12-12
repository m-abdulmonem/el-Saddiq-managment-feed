<?php

namespace App\Observers\Chicks;

use App\Models\Chick\ChickOrder;

class ChickOrderObserver
{


    public function creating( ChickOrder $chickOrder )
    {
        return $this->created( $chickOrder );
    }

    /**
     * Handle the chick order "created" event.
     *
     * @param ChickOrder $chickOrder
     * @return void
     */
    public function created(ChickOrder $chickOrder)
    {
        
    }

    /**
     * Handle the chick order "updated" event.
     *
     * @param ChickOrder $chickOrder
     * @return void
     */
    public function updated(ChickOrder $chickOrder)
    {

    }

    /**
     * Handle the chick order "deleted" event.
     *
     * @param ChickOrder $chickOrder
     * @return void
     */
    public function deleted(ChickOrder $chickOrder)
    {
        //
    }

    /**
     * Handle the chick order "restored" event.
     *
     * @param ChickOrder $chickOrder
     * @return void
     */
    public function restored(ChickOrder $chickOrder)
    {
        //
    }

    /**
     * Handle the chick order "force deleted" event.
     *
     * @param ChickOrder $chickOrder
     * @return void
     */
    public function forceDeleted(ChickOrder $chickOrder)
    {
        //
    }
}
