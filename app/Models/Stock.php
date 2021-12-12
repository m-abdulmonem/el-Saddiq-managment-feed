<?php

namespace App\Models;

use App\Models\Client\ClientProduct;
use App\Models\Client\ClientProductReturn;
use App\Models\Product\Product;
use App\Models\Product\ProductStock;
use App\Services\Products\ProductServices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model 
{

    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'stocks';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'code', 'address'];


    /**
     * @return BelongsToMany
     */
    public function products()
    {
        $columns = [
            'id',
            'ton_price',
            'piece_price',
            'sale_price',
            'quantity',
            'min_quantity',
            'expired_at',
            'notes',
            'user_id',
            'bill_id'
        ];
        return $this->belongsToMany(ProductServices::class,'products_stocks','stock_id','product_id')
            ->withPivot($columns)->withTimestamps();
    }

    public function productsStocks()
    {
        return $this->hasMany(ProductStock::class,"stock_id");
    }

    /**
     * @return HasMany
     */
    public function clientProducts()
    {
        return $this->hasMany(ClientProduct::class,'stock_id');
    }
    /**
     * @return HasMany
     */
    public function clientProductsReturn()
    {
        return $this->hasMany(ClientProductReturn::class,'stock_id');
    }





    public function scopeQuantity($query)
    {
        $data = function ($c,$k,$v){
            return $c->push($v->pivot->sum("quantity"));
        };

        return eachData($this->products,$data)->sum();
    }


    public function scopeCode($q)
    {
        return "STK-00" .($this->count() + 1);
    }

    /**
     * get record name and code
     *
     * @return string
     */
    public function scopeName($query)
    {
        return num_to_ar($this->code) . " - $this->name";
    }

}
