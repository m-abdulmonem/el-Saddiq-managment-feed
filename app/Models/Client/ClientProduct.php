<?php

namespace App\Models\Client;

use App\Models\Product\Product;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientProduct extends Model
{

    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'clients_products';
    protected $dates = ['deleted_at'];

    protected $fillable = ['quantity','price','piece_price','purchase_price','discount','client_id','product_id','bill_id','stock_id'];


    /**
     * @return BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return BelongsTo
     */
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    /**
     * @return BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function bills()
    {
        return $this->belongsTo(ClientBill::class);
    }

    /**
     * @param $query
     * @param $product_id
     * @param $bill_id
     * @return mixed
     */
    public function ScopeGetBy($query,$product_id,$bill_id)
    {
        return $query->where("product_id",$product_id)->where("bill_id",$bill_id);
    
    }
}
