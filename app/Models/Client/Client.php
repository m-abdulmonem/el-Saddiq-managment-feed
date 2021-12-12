<?php

namespace App\Models\Client;

use App\Models\Chick\BookingChick;
use App\Models\Transactions\Payments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model 
{

    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'clients';
    protected $dates = ['deleted_at'];
    protected $fillable = ['code','name','picture','discount','address','phone','is_trader','maximum_repayment_period','credit_limit'];


    /**
     * @return HasMany
     */
    public function sms()
    {
        return $this->hasMany(Sms::class, "client_id");
    }

    /**
     * @return HasMany
     */
    public function bills()
    {
        return $this->hasMany(ClientBill::class, "client_id");
    }

    /**
     * @return HasMany
     */
    public function clientProduct()
    {
        return $this->hasMany(ClientProduct::class, "client_id");
    }

    /**
     * @return HasMany
     */
    public function returnedProduct()
    {
        return $this->hasMany(ClientProductReturn::class, "client_id");
    }

    /**
     * @return HasMany
     */
    public function returnBills()
    {
        return $this->hasMany(ClientBillReturn::class, "client_id");
    }
    /**
     * @return HasMany
     */
    public function balance()
    {
        return $this->hasMany(ClientBalance::class, "client_id");
    }

    /**
     * @return HasMany
     */
    public function booking()
    {
        return $this->hasMany(BookingChick::class,"client_id");
    }

    public function payments()
    {
        return $this->hasMany(Payments::class,"client_id");
    }

    public function openBalance()
    {
        return $this->hasMany(ClientOpenBalance::class,"client_id");
    }

    /**
     * get client name
     *
     * @return string
     */
    public function scopeName($query)
    {
        return num_to_ar( $this->code ) . " - $this->name";
    }

    /**
     * limit address characters
     *
     * @param $query
     * @param int $limit
     * @return string
     */
    public function scopeLimitAddress($query,$limit = 100)
    {
        return str_limit($this->address,$limit);
    }

    /**
     * get current recorder code
     * convert english numbers to arabic numbers
     *
     * @return string
     */
    public function ScopeCode()
    {
        return num_to_ar($this->code);
    }



}
