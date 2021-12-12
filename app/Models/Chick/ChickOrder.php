<?php

namespace App\Models\Chick;

use App\Models\Supplier\SupplierBalance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChickOrder extends Model
{
    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'chick_orders';

    protected $dates = ['deleted_at','arrived_at'];

    protected $fillable =  ['name','quantity','price','chick_price','is_came','chick_id','arrived_at'];

    /**
     * @return BelongsTo
     */
    public function chick()
    {
        return $this->belongsTo(Chick::class);
    }

    /**
     * @return HasMany
     */
    public function balances()
    {
        return $this->hasMany(SupplierBalance::class, "order_id");
    }

    /**
     * @return HasMany
     */
    public function booking()
    {
        return $this->hasMany(BookingChick::class, "order_id");
    }

}
