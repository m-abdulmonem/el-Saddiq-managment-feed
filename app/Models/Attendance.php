<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model 
{

    use SoftDeletes;


    public $timestamps = true;

    protected $table = 'attendances';
    protected $dates = ['deleted_at','date'];
    protected $fillable = ['time_in','time_out','date','details','is_exist','is_holiday','user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function scopeByNow($q,$id)
    {
        return $this->where("user_id",$id)
            ->whereYear("date",date("Y"))
            ->whereMonth("date",date("m"))
            ->whereDay("date",date("d"))->get();
    }

    public function scopeHolidayByNow($query,$id)
    {
        return $this->where("user_id",$id)->where("is_holiday",true)
            ->whereYear("date",date("Y"))
            ->whereMonth("date",date("m"))
            ->whereDay("date",date("d"))->get();
    }

    public function scopeLast($query,$id)
    {
        return ($data = $this->where("user_id",$id)->latest()->first())
            ? $data->created_at->format("Y-m-d")
            : null;
    }

    public function scopeLatestHoliday($query,$id)
    {
        return ($data = $this->where("user_id",$id)->where("is_holiday",true)->latest()->first())
            ? $data->created_at->format("Y-m-d")
            : null;
    }

}
