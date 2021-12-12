<?php

namespace App\Models;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{

    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'units';
    protected $dates = ['deleted_at'];

    protected $fillable = ['name','value','symbol','query','min'];


    /**
     * product
     *
     * @return HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
}
