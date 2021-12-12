<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierProductReturn extends Model
{
    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'products_suppliers_return';
    protected $dates = ['deleted_at'];


    protected $fillable = ['quantity','price','piece_price','notes','product_id','bill_id'];
}
