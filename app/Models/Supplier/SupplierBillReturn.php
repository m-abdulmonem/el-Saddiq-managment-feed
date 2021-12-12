<?php

namespace App\Models\Supplier;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierBillReturn extends Model
{
    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'bills_suppliers_return';
    protected $dates = ['deleted_at'];
    protected $fillable = ['code','number','price','quantity','notes','supplier_id','bill_id','user_id'];

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
        return $this->belongsToMany(Product::class, 'products_suppliers_return', 'bill_id', 'product_id')
            ->withTimestamps()
            ->withPivot(['quantity', 'piece_price', 'price', 'notes','product_id','bill_id']);
    }

    /**
     * @return HasMany
     */
    public function supplierBalance()
    {
        return $this->hasMany(SupplierBalance::class,'bill_id');
    }

    /**
     * @return BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function scopeTotalPaid($q)
    {
        return $this->supplierBalance()->where('type',"receive")->sum("paid");
    }

    /**
     * @param $q
     * @param $data
     * @return mixed
     */
    public function scopeCreateWithCode($q,$data)
    {
        $new = [
            'code' => $this->code(),
            'user_id' => auth()->id(),
            'quantity' => $data['tQuantity']
        ];

        return $q->create(array_merge($data,$new));
    }

    /**
     * @param $q
     * @return int
     */
    public function scopeCode($q)
    {
        return "RTB-00" . ($q->count() + 1);
    }
}
