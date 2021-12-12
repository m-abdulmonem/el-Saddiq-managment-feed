<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banks extends Model
{
    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'stocks';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'opening_balance','phone','address'];
}
