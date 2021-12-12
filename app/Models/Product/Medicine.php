<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    public $timestamps = true;

    protected $table = 'medicines';

    protected $fillable = ['code','name','quantity','sale_price','purchase_price','profit','for','stock_in'];


    public function sales()
    {
        return $this->hasMany(MedicineSales::class,"medicine_id");
    }

    public function scopeCreateWith($q,$data)
    {
        $data = $this->create(array_merge($data,['code'=>$this->code()]));

        return jsonSuccess(trans("home.alert_success_create", ['name' => $data->name ]));
    }


    public function scopeCode($q)
    {
        return "MD-00" . ($this->count() + 1);
    }
}
