<?php

namespace App\Models\Chick;

use App\Models\Client\Client;
use App\Models\Client\ClientBalance;
use App\Models\Sms;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\JsonResponse;

class BookingChick extends Model
{
    use SoftDeletes;
    public $timestamps = true;

    protected $primaryKey = "id";

    protected $table = 'booking_chicks';
    protected $dates = ['deleted_at'];

    protected $fillable = ['code','quantity','deposit','is_came','chick_id','client_id','order_id'];


    public function chick()
    {
        return $this->belongsTo(Chick::class);
    }

    /**
     * @return BelongsToMany
     */
    public function sms()
    {
        return $this->belongsToMany(Sms::class,"booking_sms","booking_id","sms_id");
    }

    /**
     * @return BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(ChickOrder::class);
    }

    /**
     * @return BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }


    /**
     * @return HasMany
     */
    public function balances()
    {
        return $this->hasMany(ClientBalance::class,"booking_id");
    }


    /**
     * @param null $trans
     * @return JsonResponse
     * @throws Exception
     */
    public function removeRecorder($trans = null)
    {
        return  jsonSuccess( $this->delete(),1,trans("$trans.alert_success_delete",['name' => $this->client->name  ]));

    }

    public function scopeCode()
    {
        return $this->count() +1;
    }
    
}
