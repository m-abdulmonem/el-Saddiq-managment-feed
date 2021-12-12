<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class ClientOpenBalance extends Model
{
    public $timestamps = true;

    protected $table = 'client_open_balances';
    protected $fillable = ['creditor','debtor','client_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
