<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;
    use Timestamp;

    protected $table = 'jobs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];


    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function scopeIsSeller($q)
    {
        return $this->name == "بائع";
    }
    
}
