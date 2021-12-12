<?php

namespace App\Services\Sms;



use App\Models\Sms;
use Illuminate\Support\Collection;

class  SmsServices extends  Sms{

    /**
     * create sms record by fill client_id with id
     *
     * @param $sms
     * @param $id
     * @return
     */
    public function scopeCreateClientSms($q,$sms,$id)
    {
       return $this->create( $this->smsData($sms)->put("client_id",$id)->toArray() );
    }

    /**
     * create sms record by fill supplier_id with id
     *
     * @param $sms
     * @param $id
     * @return
     */
    public function createSupplierSms($sms,$id)
    {
        return $this->create( $this->smsData($sms)->put("supplier_id",$id)->toArray() );
    }


    /**
     * each nexmo response and change keys contain [ - ] to [ _ ]
     * and put send date to final array
     *
     * @param $sms
     * @return callable|Collection
     */
    private function smsData($sms)
    {
        $callback = function ($collect , $k, $v){
            return $collect->put( str_replace("-","_",$k) ,$v);
        };

        return eachData($sms, $callback)->put("send_at",now());
    }

}


