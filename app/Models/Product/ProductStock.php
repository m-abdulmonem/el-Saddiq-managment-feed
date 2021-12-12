<?php

namespace App\Models\Product;

use App\Models\Stock;
use App\Models\Supplier\SupplierBill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStock extends Model
{

    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'products_stocks';

    protected $dates = ['deleted_at','expired_at'];

    protected $fillable = ['ton_price','piece_price','sale_price','quantity','min_quantity','notes','user_id','bill_id','product_id','stock_id','expired_at'];


    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class,"product_id");
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function notification()
    {
        return $this->hasMany(NotifyExpired::class,"product_stock_id");
    }

    /**
     * @return BelongsTo
     */
    public function bill()
    {
        return $this->belongsTo(SupplierBill::class);
    }

    public function scopePurchasedProduct($q,$product,$stock)
    {
        return $q->where("product_id",$product)->where("stock_id",$stock)->where("quantity",">",0);
    }

    public function scopeIncrease($q,$product,$stock,$quantity)
    {
        return $this->purchasedProduct($product,$stock)->increment("quantity",$quantity);
    }

    public function scopeDecrease($q,$product,$stock,$quantity)
    {
        return $this->purchasedProduct($product,$stock)->decrement("quantity",$quantity);
    }
}
