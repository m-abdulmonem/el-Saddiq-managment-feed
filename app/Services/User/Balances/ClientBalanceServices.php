<?php


namespace App\Services\User\Balances;


use App\Models\Client\ClientBalance;

class ClientBalanceServices extends ClientBalance
{

    public function ByUser($user)
    {
        return $this->where("user_id",$user)->get();
    }





}
