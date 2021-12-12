<?php

namespace App\Models\Supplier;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierProduct extends Model 
{

    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'products_suppliers';
    protected $dates = ['deleted_at'];


    protected $fillable = ['quantity','price','piece_price','notes','product_id','bill_id'];

    /**
     * @return BelongsTo
     */
    public function bill()
    {
        return $this->belongsTo(SupplierBill::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class,"product_id");
    }

//    public function products()
//    {
//        return Product::with([])->find($this->product_id);
//    }
//
//
//    public function product()
//    {
//        return Product::with([])->find($this->product_id);
//    }
//
//
//    public function countQuantity()
//    {
//        $unit = $this->product()->unit;
//
//        return  $unit->query == "*"
//            ? ( ($this->quantity * $unit->value) / $this->product()->weight  )
//            : false;
//    }
//


}
