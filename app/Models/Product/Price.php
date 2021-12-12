<?php

namespace App\Models\Product;

use App\Models\Supplier\SupplierBill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model 
{

    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'products_prices';

    protected $dates = ['deleted_at','finished_at'];

    protected $fillable = ['price','sale_price','quantity','value','is_cheaper','product_id',"bill_id",'user_id','finished_at'];


    /**
     * @return BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

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
    public function bills()
    {
        return $this->belongsTo(SupplierBill::class);
    }

    /**
     * get value of new price
     *
     * @param $query
     * @param $price
     * @param $id
     * @return int
     */
    public function scopeCalcValue($query,$price,$id)
    {
        return ($oldPrice = $this->where('product_id',$id)->latest()->first()) ? $oldPrice->price - $price : 0;
    }

    /**
     * check is been cheaper or not
     *
     * @param $query
     * @param $price
     * @param $id
     * @return bool
     */
    public function scopeIsCheaperById($query,$price,$id)
    {
        if ($product = $query->where("product_id",$id)->latest()->first())
            return $price < $product->price;
        return false;
    }

}
