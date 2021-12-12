<?php

namespace App\Models\Transactions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expenses extends Model
{

    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'expenses';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'code'];

    public function payments()
    {
        return $this->hasMany(Payments::class,"expense_id");
    }


    public function scopeCreateWith($q,$data)
    {
        $data = $this->create(array_merge($data,['code' => $this->code()]));

        return jsonSuccess(trans("home.alert_success_create",['name' => $data->name]),$data);
    }

    public function scopeCode($q)
    {
        return 'EX-'. ($q->count() +1);
    }
}
