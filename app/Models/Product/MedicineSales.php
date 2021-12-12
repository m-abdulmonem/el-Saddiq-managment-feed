<?php

namespace App\Models\Product;

use App\Models\Dailies\Daily;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class MedicineSales extends Model
{
    public $timestamps = true;

    protected $table = 'medicine_sales';

    protected $fillable = ['quantity','price','medicine_id','user_id','daily_id'];


    public function medicine()
    {
        return $this->belongsTo(Medicine::class,"medicine_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }

    public function daily()
    {
        return $this->belongsTo(Daily::class,"daily_id");
    }

    public function scopeCreateWith($q,$request,$daily,$price,$k,$id)
    {
        return $this->create([
            'price' => $price * $request->quantity[$k],
            'quantity' => $request->quantity[$k],
            'daily_id' => $daily->today()->id,
            'user_id' => auth()->id(),
            'medicine_id' => $id,
        ]);
    }

}
