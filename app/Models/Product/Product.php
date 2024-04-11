<?php

namespace App\Models\Product;

use App\Models\Unit;
use App\Models\User;
use App\Models\Stock;
use App\Models\Category;
use Laravel\Scout\Searchable;
use App\Models\Client\ClientBill;
use App\Models\Supplier\Supplier;
use App\Models\Client\ClientProduct;
use App\Models\Supplier\SupplierBill;
use App\Models\Client\ClientBillReturn;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier\SupplierProduct;
use App\Models\Client\ClientProductReturn;
use App\Models\Supplier\SupplierBillReturn;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{


    use SoftDeletes, Searchable;
    public $timestamps = true;

    protected $table = 'products';
    protected $dates = ['deleted_at'];
    protected $fillable = ['code', 'name', 'image', 'weight', 'profit', 'discount', 'notes', 'valid_for', 'is_printed', 'supplier_id', 'category_id', 'user_id', 'unit_id'];



    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
        ];
    }

    public function clientProduct()
    {
        return $this->hasMany(ClientProduct::class , "product_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clientProductReturn()
    {
        return $this->hasMany(ClientProductReturn::class , "product_id");
    }
    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * @return BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsToMany
     */
    public function stocks()
    {
        $columns = [
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
        return $this->belongsToMany(Stock::class , 'products_stocks', 'product_id', 'stock_id')
            ->withPivot($columns)
            ->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function discounts()
    {
        return $this->belongsToMany(ClientBill::class , 'discount_products', 'product_id', 'bill_id')
            ->withPivot(['discount'])
            ->withTimestamps();
    }


    public function prices()
    {
        return $this->hasMany(Price::class , "product_id");
    }

    public function supplierBills()
    {
        return $this->belongsToMany(SupplierBill::class , 'products_suppliers', "product_id", 'bill_id')
            ->withPivot(['quantity', 'piece_price', 'price', 'notes', 'product_id', 'bill_id'])->withTimestamps();
    }

    public function productsSupplier()
    {
        return $this->hasMany(SupplierProduct::class , "product_id");
    }

    public function supplierBillsReturn()
    {
        $columns = ['quantity', 'piece_price', 'price', 'notes', 'product_id', 'bill_id'];

        return $this->belongsToMany(SupplierBillReturn::class , 'products_suppliers_return', "product_id", 'bill_id')
            ->withPivot($columns)->withTimestamps();

    }

    public function productsStocks()
    {
        return $this->hasMany(ProductStock::class , "product_id");
    }

    /**
     * @return BelongsToMany
     */
    public function clientBills()
    {
        return $this->belongsToMany(ClientBill::class , 'clients_products', "product_id", 'bill_id')
            ->withPivot(['quantity', 'piece_price', 'purchase_price', 'price', 'discount', 'stock_id', 'client_id'])
            ->withTimestamps();
    }
    public function returnedInvoices()
    {
        return $this->belongsToMany(ClientBillReturn::class , 'products_clients_return', "product_id", 'bill_id')
            ->withPivot(['quantity', 'piece_price', 'price', 'stock_id', 'client_id'])
            ->withTimestamps();
    }
    /**
     * get product weight and unit symbol
     *
     * @return string
     */
    public function scopeWeight($query)
    {
        return num_to_ar($this->weight) . " " . $this->unit->min;
    }

    /**
     * @param $query
     * @return array
     */
    public function scopeStocksName($query)
    {
        return $this->stocks()->latest()->get()->pluck("name")->unique()->toArray();
    }

    /**
     * @return float|int|null
     */
    public function scopeCount()
    {
        return ($weight = $this->weight) ? (1000 / $weight) : null;
    }

    /**
     * get record name with code and supplier name
     *
     * @return string
     */
    public function scopeName($query)
    {
        return to_arabic_int($this->code) . " - $this->name " . $this->supplier->name;
    }

    /**
     * get record name and code only
     *
     * @return string
     */
    public function scopeNameCode($query)
    {
        return to_arabic_int($this->code) . " - $this->name";
    }

    /**
     * get record name and supplier name
     *
     * @return string
     */
    public function scopeNameSupplier($query)
    {
        return "$this->name " . $this->supplier->name;
    }
    /**
     * count all product to get code of new product
     *
     * @return mixed
     */
    public function scopeCode($q)
    {
        return $q->get()->count() + 1;
    }

    /**
     * check if the product is available
     *
     * @param $q
     * @return mixed
     */
    public function scopeAvailableStocks($q)
    {
        return $this->stocks()->latest("quantity")->get();
    }


    /**
     * get sale price of product
     *
     * @return mixed
     */
    public function scopeSalePrice($q)
    {
        if ($stock = $this->stocks()->latest()->first())
            return $stock->pivot->sale_price;
    }

}
