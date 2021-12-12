<?php

namespace App\Models\Transactions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'banks';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'opening_balance','phone','address'];


    public function payments()
    {
        return $this->hasMany(Payments::class,"bank_id");
    }
    public function catches()
    {
        return $this->hasMany(CatchPurchase::class,"bank_id");
    }

    public function scopeCreateWith($q,$data)
    {
        $data = $q->create(array_merge($data,['code' => $this->code()]));

        return jsonSuccess(trans("home.alert_success_create",['name' => $data->name]),$data);
    }

    public function scopeCode($q)
    {
        return 'BK-'. ($q->count() +1);
    }
}
