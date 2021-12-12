<?php

namespace App\Models\Client;

use App\Models\Product\Product;
use App\Models\Client\Pivot\ClientProductReturn;
use App\Services\Clients\bills\InvoicesServices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientBillReturn extends Model
{

    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'bills_clients_return';

    protected $dates = ['deleted_at'];

    protected $fillable = ['code','price','quantity','notes','client_id','bill_id','user_id','stock_id'];


    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_clients_return', 'bill_id', 'product_id')
            ->using(ClientProductReturn::class)
            ->withPivot(['quantity', 'piece_price', 'price','stock_id','client_id'])
            ->withTimestamps();
    }

    /**
     * @return HasMany
     */
    public function clientBalance()
    {
        return $this->hasMany(ClientBalance::class,'bill_id');
    }

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
    public function clientBill()
    {
        return $this->belongsTo(InvoicesServices::class,"bill_id");
    }


    /**
     * @return HasMany
     */
    public function balances()
    {
        return $this->hasMany(ClientBalance::class,"bill_id");
    }

    /**
     * @param $q
     * @param $data
     * @return mixed
     */
    public function scopeCreateWithCode($q,$data)
    {
        $new = [
            'code' => $this->code($data['bill_id']),
            'user_id'=> auth()->id(),
            'quantity' =>$data['total_quantity'],
            'price' => $data['total_price']
        ];

        return $q->create(array_merge($data,$new));
    }


    /**
     * get bill type
     *
     * @return string
     */
    public function scopeType(){
        return trans("clients/bills.discarded_sale");
    }

    /**
     * @param $id
     * @return int
     */
    public function scopeCode($q,$id)
    {
        return  "RTI-" . ($this->where("bill_id",$id)->count() +1);
    }

    public function scopeBtnPrint()
    {
        $url = route("ajax.client.print.returned.invoice",$this->id);

        return "<a href='$url' class='btn btn-secondary' target='_blank'><i class='fa fa-print'></i> </a>";
    }


}
