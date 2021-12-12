<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model 
{

    protected $table = 'files';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function coupon()
    {
        return $this->belongsTo('App\Models\Coupon');
    }

    public function offer()
    {
        return $this->belongsTo('App\Models\Offer');
    }

}