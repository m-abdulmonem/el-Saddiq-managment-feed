<?php

namespace App\Models\Client;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientBalance extends Model
{

    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'balances_clients';
    protected $dates = ['deleted_at'];
    protected $fillable = ['code','remaining_amount','paid','type','notes','bill_id','booking_id','client_id','user_id'];

    /**
     * @return BelongsTo
     */
    public function bills()
    {
        return $this->belongsTo(ClientBill::class);
    }

    /**
     * @return BelongsTo
     */
    public function billsReturn()
    {
        return $this->belongsTo(ClientBillReturn::class,"bill_id");
    }

    /**
     * @return BelongsTo
     */
    public function clients()
    {
        return $this->belongsTo(Client::class,'client_id');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * create new code
     *
     * @return int
     */
    public function scopeCode()
    {
        return $this->count() +1 ;
    }


    /**
     * get transaction type with it code
     *
     * @param $query
     * @return string
     */
    public function scopeName($query)
    {
        return num_to_ar($this->code) . " - " .trans("balances.option_$this->type");
    }


}
