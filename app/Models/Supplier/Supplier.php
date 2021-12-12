<?php

namespace App\Models\Supplier;

use App\Models\Chick\Chick;
use App\Models\Product\Product;
use App\Models\Transactions\Payments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model 
{

    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'suppliers';
    protected $dates = ['deleted_at'];
    protected $fillable = ['code','my_code','name','logo','discount','phone','address'];


    /**
     *
     * @return HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class,"supplier_id");
    }

    /**
     * @return HasMany
     */
    public function bill()
    {
        return $this->hasMany(SupplierBill::class,"supplier_id");
    }

    /**
     * @return HasMany
     */
    public function returnBill()
    {
        return $this->hasMany(SupplierBillReturn::class,"supplier_id");
    }

    /**
     * @return HasMany
     */
    public function balance()
    {
        return $this->hasMany(SupplierBalance::class,"supplier_id");
    }

    /**
     * @return HasMany
     */
    public function chicks()
    {
        return $this->hasMany(Chick::class,"supplier_id");
    }
    public function payments()
    {
        return $this->hasMany(Payments::class,"supplier_id");
    }

    public function openBalance()
    {
        return $this->hasMany(SupplierOpenBalance::class,'supplier_id');
    }


    /**
     * get record name
     *
     * @param $query
     * @return string
     */
    public function scopeName($query)
    {
        return num_to_ar($this->code) . " - $this->name";
    }



}
