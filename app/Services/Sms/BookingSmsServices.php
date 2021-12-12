<?php


namespace App\Services\Sms;


use App\Models\Chick\BookingSms;
use App\Models\Sms;

class BookingSmsServices
{

    /**
     * @var Sms
     */
    private $sms;
    /**
     * @var SmsServices
     */
    private $services;
    /**
     * @var BookingSms
     */
    private $bookingSms;

    /**
     * BookingSmsServices constructor.
     *
     * @param Sms $sms
     * @param SmsServices $services
     * @param BookingSms $bookingSms
     */
    public function __construct(Sms $sms, SmsServices $services,BookingSms $bookingSms)
    {
        $this->sms = $sms;
        $this->services = $services;
        $this->bookingSms = $bookingSms;
    }

    /**
     * create a new [sms] record and [booking sms] record
     *
     * @param $sms
     * @param $booking
     * @return array
     */
    public function create($sms,$booking)
    {
        $sms = $this->services->createClientSms($sms,$booking->client_id);

        $data = $this->bookingSms->create([
            'sms_id' => $sms->id,
            'booking_id' => $booking->id,
            'client_id' => $booking->client_id,
            'send_at' =>now()
        ]);

        return [$sms,$data];
    }


}
