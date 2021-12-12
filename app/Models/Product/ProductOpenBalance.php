<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class ProductOpenBalance extends Model
{
    public $timestamps = true;

    protected $table = 'product_open_balances';

    protected $fillable = ['creditor','debtor','product_stock_id','product_id'];
}
