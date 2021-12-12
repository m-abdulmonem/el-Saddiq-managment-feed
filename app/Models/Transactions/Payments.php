<?php

namespace App\Models\Transactions;

use App\Models\Client\Client;
use App\Models\Client\ClientBalance;
use App\Models\Client\ClientBill;
use App\Models\Client\ClientBillReturn;
use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierBalance;
use App\Models\Supplier\SupplierBill;
use App\Models\User;
use App\Services\Clients\bills\InvoicesServices;
use App\Services\Supplier\Bills\BillServices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payments extends Model
{
    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'payments';
    protected $dates = ['deleted_at'];
    protected $fillable = ['code','payment','payment_type','paid','bill_id','client_bill_id','balance_id','supplier_id','bank_id','expense_id','client_id','user_id'];


    public function bills()
    {
        return $this->belongsTo(SupplierBill::class);
    }

    public function clientBills()
    {
        return $this->belongsTo(ClientBillReturn::class);
    }

    public function balances()
    {
        return $this->belongsTo(SupplierBalance::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function expense()
    {
        return $this->belongsTo(Expenses::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
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
        return $this->balances()->create([
            'code' => SupplierBalance::code(),
            'paid' => $request->paid,
            'type' => 'payment',
            'bill_id' => $request->bill_id,
            'supplier_id' => BillServices::find($request->bill_id)->supplier_id,
            'user_id' => auth()->id()
        ]);
    }

    public function scopeCreateClientBalance($q,$request)
    {
        return ClientBalance::create([
            'code' => ClientBalance::code(),
            'paid' => $request->paid,
            'type' => 'payment',
            'bill_id' => ClientBillReturn::find($request->client_bill_id)->bill_id,
            'client_id' => InvoicesServices::find($request->client_bill_id)->client_id,
            'user_id' => auth()->id()
        ]);
    }
    public function scopeCode($q)
    {
        return 'PT-00'. ($q->count() +1);
    }
}
