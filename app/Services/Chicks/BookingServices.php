<?php

namespace App\Services\Chicks;


use App\Http\Requests\Chicks\Booking\CreateRequest;
use App\Models\Chick\BookingChick;
use App\Models\Chick\ChickOrder;
use App\Models\Client\ClientBalance;
use App\Services\Balances\ClientServices;
use App\Services\Clients\ClientsServices;
use App\Services\Sms\BookingSmsServices;
use App\Services\Sms\SmsServices;
use App\Services\User\Balances\ClientBalanceServices;

class bookingServices extends BookingChick{

    /**
     * @var BookingChick
     */
    private $order;
    /**
     * @var ClientServices
     */
    private $balanceServices;
    /**
     * @var ClientsServices
     */
    private $clientsServices;


    private $smsServices;


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->balanceServices = new ClientBalanceServices();
        $this->clientsServices = new ClientsServices();
        $this->smsServices = new SmsServices();
        $this->order = new ChickOrder();

    }

    public function sort($request)
    {
        if ($user = $request->user)
            $data  = $this->byUser($user);
        elseif ($client = $request->client)
            $data = $this->byClient($client);
        elseif ($order = $request->orders)
            $data = $this->byOrder($order);
        else if ($chick = $request->chick)
            $data = $this->byChick($chick);
        else if ($status = $request->status)
            $data = $this->byStatus($status);
        else
            $data = $this->latest()->get();

        return $data;
    }

    /**
     * get all record by given order id
     *
     * @param $order
     * @return mixed
     */
    public function byOrder($order)
    {
        return $this->where("order_id",$order)->latest()->get();
    }
    
    /**
     * get all chick booking by orders
     *
     * @param $id
     * @return mixed
     */
    public function byChick($id)
    {
        $orders = $this->order->where("chick_id",$id)->pluck("id");

        return $this->whereIn("order_id",$orders)->latest()->get();
    }

    /**
     * get all record has the given user id
     * @param $id
     * @return mixed
     */
    public function byUser($id)
    {
        return $this->where("user_id",$id)->latest()->get();
    }

    public function byClient($id)
    {
        return $this->where("client_id",$id)->latest()->get();
    }

    /**
     * @param $status
     * @return mixed
     */
    public function byStatus($status)
    {
        return $this->where("is_came",$status)->latest->get();
    }


    /**
     * send sms when create a new booking
     *
     * @return
     */
    public function smsConfirmOrder()
    {
        $text = trans("chicks/booking.sms_confirm_order",['quantity' => $this->quantity]);

        return $this->smsServices->createClientSms( nexmo($this->client->phone,$text) , $this->client_id );
    }

    /**
     * send sms when change booking quantity
     *
     * @param SmsServices $sms
     * @param $booking
     * @return
     */
    public function smsQuantityChanged(SmsServices $sms)
    {
        $text = trans("chicks/booking.sms_quantity_changed",['quantity' => $this->quantity]);

        return $sms->createClientSms(nexmo($this->phone, $text),$this->client_id);
    }

    /**
     * send sms when click resend to client to alert him the chicks are arrived
     *
     * @param BookingSmsServices $services
     * @return array
     */
    public function smsResendDelivered(BookingSmsServices $services)
    {
        $sms = nexmo($this->phone, trans("chicks/booking.sms_resend_delivered"));

        return $services->create($sms,$this);
    }

    /**
     * @param SmsServices $sms
     * @return mixed
     */
    public function smsDeliveredDate(SmsServices $sms)
    {
        $text = trans("chicks/booking.sms_delivered_date");

        return $sms->createClientSms(nexmo($this->phone,$text),$this->client_id);
    }


    /**
     * create a new record with fill client_id  column
     *
     * @param CreateRequest $request
     * @return mixed
     */
    public function createWithCode($request)
    {
        $data = ['client_id' => $this->clientsServices->findOrNew($request)->id,'code'=>$this->code(),'user_id' => auth()->id()];

        $data =  $this->create( array_merge($request->all() , $data) );

        return jsonSuccess( trans("home.alert_success_create", ['name' => '' ] ) ,$data->createBalance($request) );
    }

    /**
     * create new deposit transaction
     *
     * @param $request
     */
    public function createBalance($request)
    {
        $this->balances()->create([
            'code' => ClientBalance::code(),
            'remaining_amount' => 0,
            'paid' => $request->deposit,
            'type' => "deposit",
            'notes' => trans("balances.deposit"),
            'client_id' => $request->client_id,
            'user_id' => auth()->id()
        ]);
    }

    /**
     * check of current time are greater than send at time
     *
     * @return bool
     */
    public function isAfterHour()
    {
        return now() >= $this->sendAtPlusHour();
    }

    /**
     *
     * @return bool
     */
    public function isOrderArrive()
    {
        return now() == $this->order->arrive_at->subDay();
    }
    
    /**
     * add one hour to send at time
     *
     * @return null
     */
    public function sendAtPlusHour()
    {
        return ( $booking = $this->sms()->latest()->first()  ) ? $booking->send_at->addHour() : null;
    }


    /**
     * @param $request
     * @return bool|mixed
     */
    public function delivered($request)
    {
        $this->update(['is_came'=>true]);

        return $this->balances()->create([
            'code' => $this->code(),
            'remaining_amount' => ($this->quantity * $this->order->chick_price) - $this->balances()->sum("paid"),
            'paid' => $request->paid,
            'type' => 'payment',
            'user_id' => auth()->id(),
            'client_id' => $this->client_id,
        ]);

//        return $this->balanceServices->createDeliveredBooking($booking,$request);
    }
    
}
