<?php

namespace App\Models\Chick;

use App\Models\Client\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingSms extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'booking_sms';

    protected $dates = ['deleted_at','send_at'];

    protected $fillable = ['sms_id','booking_id','client_id'];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }


    public function booking()
    {
        return $this->belongsTo(BookingChick::class);
    }


}
