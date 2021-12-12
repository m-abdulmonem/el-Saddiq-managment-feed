<?php

namespace App\Models\Client;

use App\Models\Product\Product;
use App\Models\Product\ProductStock;
use App\Models\Transactions\CatchPurchase;
use App\Models\Transactions\Payments;
use App\Services\Clients\ClientsServices;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Client\Pivot\ClientProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Models\User;

class ClientBill extends Model 
{

    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'bills_clients';
    protected $dates = ['deleted_at'];
    protected $fillable = ['code','discount','price','status','quantity','notes','is_cash','user_id','client_id'];


    /**
     * @return BelongsToMany
     */
    public function products()
    {
        $columns = ['quantity', 'piece_price','purchase_price', 'price','discount','stock_id'];

        return $this->belongsToMany(Product::class, 'clients_products', 'bill_id', 'product_id')
            ->using(ClientProduct::class)
            ->withPivot($columns)
            ->withTimestamps();
    }

    public function discounts()
    {
        return $this->belongsToMany(Product::class, 'discount_products', 'bill_id', 'product_id')
            ->withPivot(['discount','client_id'])
            ->withTimestamps();
    }

    /**
     * @return HasMany
     */
    public function invoices()
    {
        return $this->hasMany(ClientBillReturn::class,"bill_id");
    }
    /**
     * @return BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(ClientsServices::class);
    }

    /**
     * @return HasMany
     */
    public function balances()
    {
        return $this->hasMany(ClientBalance::class,"bill_id");
    }

    /**
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function payments()
    {
        return $this->hasMany(Payments::class,"client_bill_id");
    }
    public function catches()
    {
        return $this->hasMany(CatchPurchase::class,"invoice_id");
    }

    /**
     * get bill code
     *
     * @param $id
     * @return int
     */
    public function scopeCode($q)
    {
        return $q->count() + 1;
    }

    /**
     * get bill type
     *
     * @return string
     */
    public function scopeType($q){
        return trans("clients/bills.sale");
    }

}
