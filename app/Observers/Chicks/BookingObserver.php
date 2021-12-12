<?php

namespace App\Observers\Chicks;

use App\Models\Chick\BookingChick;
use App\Services\Chicks\bookingServices;

class BookingObserver
{

    public function __construct()
    {

    }

    /**
     * Handle the booking chick "created" event.
     *
     * @param bookingServices $booking
     * @return void
     */
    public function created(bookingServices $booking)
    {
        if (nexmoBalanceCheck()) $booking->smsConfirmOrder();
    }

    /**
     * Handle the booking chick "creating" event.
     *
     * @param BookingChick $booking
     * @return void
     */
    public function creating(bookingServices $booking)
    {

    }
    

    /**
     * Handle the booking chick "updated" event.
     *
     * @param  \App\Models\BookingChick  $bookingChick
     * @return void
     */
    public function updated(BookingChick $bookingChick)
    {
        //
    }

    /**
     * Handle the booking chick "updating" event.
     *
     * @param BookingChick $booking
     * @return void
     */
    public function updating(BookingChick $booking)
    {
//        if (! $this->services->isDelivered($booking))
//            $this->services->smsQuantityChanged($this->smsServices,$booking);
    }



    /**
     * Handle the booking chick "deleted" event.
     *
     * @param  \App\Models\BookingChick  $bookingChick
     * @return void
     */
    public function deleted(BookingChick $bookingChick)
    {
        //
    }

    /**
     * Handle the booking chick "restored" event.
     *
     * @param  \App\Models\BookingChick  $bookingChick
     * @return void
     */
    public function restored(BookingChick $bookingChick)
    {
        //
    }

    /**
     * Handle the booking chick "force deleted" event.
     *
     * @param  \App\Models\BookingChick  $bookingChick
     * @return void
     */
    public function forceDeleted(BookingChick $bookingChick)
    {
        //
    }
}
