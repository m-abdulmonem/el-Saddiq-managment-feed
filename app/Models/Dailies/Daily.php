<?php

namespace App\Models\Dailies;

use App\Models\Client\ClientBalance;
use App\Models\Product\MedicineSales;
use App\Models\Transactions\Payments;
use App\Models\User;
use App\Models\User\Salary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Daily extends Model
{
    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'dailies';
    protected $dates = ['deleted_at','time_in','time_out'];
    protected $fillable = ['number', 'time_in','time_out','balance','net_sales','inc_dec','user_id'];


    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }


    public function scopeToday($q)
    {
        return $this->whereDay("created_at",now()->format("d"))
            ->whereMonth("created_at",now()->format("m"))
            ->whereYear("created_at",now()->format("Y"))
            ->first();
    }

    public function today()
    {
        return $this->whereDay("created_at",now()->format("d"))
            ->whereMonth("created_at",now()->format("m"))
            ->whereYear("created_at",now()->format("Y"))
            ->first();
    }

    public function netSales()
    {
        $payment = new Payments();
        $medicine = new MedicineSales();
        $balance = new ClientBalance();
        $salary = new Salary();

        $payments = ($payment->today()->sum("paid") + $salary->today()->sum("salary") +  $salary->today()->sum("increase")  - $salary->today()->sum("discount"));
        $sales = ($balance->today()->where("type","catch")->sum("paid")+ $medicine->today()->sum("price"));
        return ($sales - $payments);
    }

    public function scopeCode($q)
    {
        return "DLY-00" . ($this->count() + 1);
    }
}
