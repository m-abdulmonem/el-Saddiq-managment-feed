<?php

namespace App\Models;

use App\Models\Chick\BookingChick;
use App\Models\Client\ClientBalance;
use App\Models\Client\ClientBill;
use App\Models\Client\ClientBillReturn;
use App\Models\Dailies\Daily;
use App\Models\Product\Product;
use App\Models\Product\ProductStock;
use App\Models\Sms\SmsBodies;
use App\Models\Supplier\SupplierBillReturn;
use App\Models\Transactions\CatchPurchase;
use App\Models\Transactions\Payments;
use App\Models\User\Salary;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,HasRoles,SoftDeletes;

    public $timestamps = true;

    protected $guard_name = 'web';

    protected $table = 'users';

    protected $dates = ['deleted_at'];

    protected $fillable = ['code','name','username','email','password','phone','address','picture','salary','salary_type','credit_limit','discount_limit','holidays','is_active','job_id'];


    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * @return HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return HasMany
     */
    public function stocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    public function blanaces()
    {
        return $this->hasMany('App\Models\Balance');
    }

    public function supplierBill()
    {
        return $this->hasMany('App\Models\SupplierBill');
    }

    public function supplierBillReturn()
    {
        return $this->hasMany(SupplierBillReturn::class,"user_id");
    }
    
    public function supplierBalance()
    {
        return $this->hasMany('App\Models\SupplierBalance');
    }

    public function prices()
    {
        return $this->hasMany('App\Models\Price');
    }

    public function clientBills()
    {
        return $this->hasMany(ClientBill::class,"user_id");
    }

    public function clientBillsReturn()
    {
        return $this->hasMany(ClientBillReturn::class,"user_id");
    }

    public function clientBalance()
    {
        return $this->hasMany(ClientBalance::class,'user_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }

    public function chicksBooking()
    {
        return $this->hasMany(BookingChick::class,"user_id");
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class,"user_id");
    }

    public function smsBodies()
    {
        return $this->hasMany(SmsBodies::class,'user_id');
    }
    public function payments()
    {
        return $this->hasMany(Payments::class,"user_id");
    }
    public function catches()
    {
        return $this->hasMany(CatchPurchase::class,"user_id");
    }

    public function dailies()
    {
        return $this->hasMany(Daily::class,"user_id");
    }
    /**
     * get client name with code
     *
     * @return string
     */
    public function scopeName($query)
    {
        return num_to_ar( $this->code ) . " - $this->name";;
    }


    public function scopeCreditLimit($q)
    {
        $price = $this->clientBills()
            ->whereYear("created_at",now()->format("Y"))
            ->whereMonth("created_at",now()->format("m"))->sum("price");
        $balance = $this->clientBalance()
            ->whereYear("created_at",now()->format("Y"))
            ->whereMonth("created_at",now()->format("m"))
            ->where("type","catch")->sum("paid");

        return (($credit = $price - $balance) > 0)
            ? (auth()->user()->credit_limit - $credit)
            : "";
    }

    public function scopeDiscountLimit($q)
    {
        $discount = $this->clientBills()
            ->whereYear("created_at",now()->format("Y"))
            ->whereMonth("created_at",now()->format("m"))
            ->sum("discount");

        return auth()->user()->discount_limit - $discount;
    }


    public function scopeIsSeller($q)
    {
        return ($this->job->name === "بائع");
    }

    public function scopeIsAdmin($q)
    {
        return ($this->job->name === "مدير");
    }

}
