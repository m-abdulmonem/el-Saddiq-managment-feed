<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'categories';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'details', 'image'];





}
