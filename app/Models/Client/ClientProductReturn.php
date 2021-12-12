<?php

namespace App\Models\Client;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientProductReturn extends Model
{
    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'products_clients_return';
    protected $dates = ['deleted_at'];


    protected $fillable = ['quantity','price','piece_price','notes','client_id','product_id','bill_id'];


    public function clients()
    {
        return $this->belongsTo(Client::class);
    }

    public function products()
    {
        $this->belongsTo(Product::class);
    }
}
