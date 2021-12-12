<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountProduct extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $table = 'discount_products';
    protected $fillable = ['discount','product_id','bill_id','user_id'];


}
