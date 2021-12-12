<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salary extends Model
{

//    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'salaries';
    protected $dates = ['deleted_at'];
    protected $fillable = ['salary','increase','discount', 'notes', 'user_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

//    public function scopeCreateWith($q,$data)
//    {
//        $create = $this->create(array_merge($data,['user_id' => auth()->id()]));
//
//        return jsonSuccess( trans("home.alert_success_create"),$create);
//    }
}
