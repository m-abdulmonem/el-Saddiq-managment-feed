<?php

namespace App\Models\Supplier;

use App\Models\Product\Price;
use App\Models\Product\Product;
use App\Models\Product\ProductStock;
use App\Models\Transactions\CatchPurchase;
use App\Models\Transactions\Payments;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SupplierBill extends Model 
{

    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'bills_suppliers';

    protected $dates = ['deleted_at'];

    protected $fillable = ['code','number','driver','car_number','discount','discount','price','quantity','status','is_cash','notes','supplier_id','user_id'];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function products()
    {
        $columns = ['quantity', 'piece_price', 'price', 'notes', 'product_id', 'bill_id'];

        return $this->belongsToMany(Product::class, 'products_suppliers', 'bill_id', 'product_id')
            ->withPivot($columns)->withTimestamps();
    }

    /**
     * @return HasMany
     */
    public function balances()
    {
        return $this->hasMany(SupplierBalance::class,'bill_id');
    }

    /**
     * @return HasMany
     */
    public function productsStocks()
    {
        return $this->hasMany(ProductStock::class,'bill_id');
    }

    /**
     * @return BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * @return HasMany
     */
    public function product()
    {
        return $this->hasMany(SupplierProduct::class,"bill_id");
    }

    /**
     * @return HasMany
     */
    public function prices()
    {
        return $this->hasMany(Price::class,"bill_id");
    }

    /**
     * @return HasMany
     */
    public function returnedBills()
    {
        return $this->hasMany(SupplierBillReturn::class,"bill_id");
    }

    public function payments()
    {
        return $this->hasMany(Payments::class,"bill_id");
    }
    public function catches()
    {
        return $this->hasMany(CatchPurchase::class,"bill_id");
    }

    /**
     * @param $query
     * @return int
     */
    public function scopeCode($query)
    {
        return $query->count() +1;
    }

    /**
     * get type
     *
     * @param $query
     * @return array|Translator|string|null
     */
    public function scopeType($query)
    {
        return trans("suppliers/bills.bill");
    }

    public function scopeStatus($query)
    {
        return trans("suppliers/bills.$this->status");
    }
}
