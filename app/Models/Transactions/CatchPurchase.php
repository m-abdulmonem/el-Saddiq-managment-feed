<?php

namespace App\Models\Transactions;

use App\Models\Supplier\SupplierBillReturn;
use App\Services\Clients\bills\InvoicesServices;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\Supplier\Bills\BillServices;
use App\Models\Supplier\SupplierBalance;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier\SupplierBill;
use App\Models\Client\ClientBalance;
use App\Models\Client\ClientBill;
use App\Models\User;

class CatchPurchase extends Model
{
    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'catch_purchases';
    protected $dates = ['deleted_at'];
    protected $fillable = ['code','type','paid','bill_id','invoice_id','balance_id','bank_id','user_id'];

    public function bills()
    {
        return $this->belongsTo(SupplierBillReturn::class,"bill_id");
    }

    public function invoices()
    {
        return $this->belongsTo(InvoicesServices::class,"invoice_id");
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function scopeCreateWith($q,$data)
    {
        $data = array_merge($data,['code' => $this->code(),'user_id'=>auth()->id()]);

        return jsonSuccess(trans("home.alert_success_create",['name' => null]),$this->create($data));
    }

    public function scopeCreateBalance($q,$request)
    {
        return SupplierBalance::create([
            'code' => SupplierBalance::code(),
            'paid' => $request->paid,
            'type' => 'receive',
            'bill_id' => $request->bill_id,
            'supplier_id' => SupplierBillReturn::find($request->bill_id)->supplier_id,
            'user_id' => auth()->id()
        ]);
    }

    public function scopeCreateClientBalance($q,$request)
    {
        return ClientBalance::create([
            'code' => ClientBalance::code(),
            'paid' => $request->paid,
            'type' => 'catch',
            'bill_id' => $request->invoice_id,
            'client_id' => InvoicesServices::find($request->invoice_id)->client_id,
            'user_id' => auth()->id()
        ]);
    }
    public function scopeCode($q)
    {
        return 'RCT-00'. ($q->count() +1);
    }
}
