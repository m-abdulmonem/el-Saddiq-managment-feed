<?php

namespace App\Models;

use App\Models\Chick\BookingChick;
use App\Models\Sms\SmsBodies;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sms extends Model
{

    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'sms';
    protected $dates = ['deleted_at','send_at'];
    protected $fillable = ['to','message_id','remaining_balance','message_price','network','status','error_text','provider','client_id','supplier_id'];

    /**
     * @return HasMany
     */
    public function bodies()
    {
        return $this->hasMany(SmsBodies::class,'sms_id');
    }

    /**
     * @return BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return BelongsToMany
     */
    public function booking()
    {
        return $this->belongsToMany(BookingChick::class,"booking_sms")
            ->withTimestamps();
    }
}
