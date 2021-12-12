<?php

namespace App\Models\Supplier;

use App\Models\Transactions\Payments;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierBalance extends Model 
{

    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'balances_suppliers';
    protected $dates = ['deleted_at'];
    protected $fillable = ['code','remaining_amount','paid','opening_balance','type','bill_id','order_id','supplier_id','user_id','notes'];


    /**
     *
     * @return BelongsTo
     */
    public function bill()
    {
        return $this->belongsTo(SupplierBill::class);
    }

    /**
     * @return BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * @return BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(ChickOrder::class);
    }

    /**
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function payments()
    {
        return $this->hasMany(Payments::class,"balance_id");
    }


    /**
     * get record transaction type with transaction code
     *
     * @param $query
     * @return string
     */
    public function scopeName($q)
    {
        return "$this->code - " . trans("balances.option_$this->type");
    }

    /**
     * @return int
     */
    public function scopeCode($q)
    {
        return $this->count()+1;
    }

}
