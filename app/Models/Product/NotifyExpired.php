<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class NotifyExpired extends Model
{

    protected $table = 'notify_expires';
    
    protected $fillable = ['text' ,'remaining_days','quantity','is_read','user_id','sms_id','product_stock_id'];


    public function product()
    {
        return $this->belongsTo(ProductStock::class,"product_stock_id");
    }



}
