<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Model;

class SupplierOpenBalance extends Model
{
    public $timestamps = true;

    protected $table = 'supplier_open_balances';
    protected $fillable = ['creditor','debtor','supplier_id'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
