<?php

namespace App\Models\Sms;

use App\Models\Sms;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsBody extends Model
{
//    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'sms_bodies';
    protected $dates = ['deleted_at'];
    protected $fillable = ['code','text','body','sms_id','user_id'];

    public function sms()
    {
        return $this->belongsTo(Sms::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function scopeFindBy($q,$code)
    {
        return $q->where("code",$code)->first();
    }
}
