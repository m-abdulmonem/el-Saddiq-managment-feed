<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{

    protected $table = 'settings';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['site_name_ar','site_name_en','logo','icon','lang','email', 'description','keywords','status',
        'maintenance_message','paginate','maintenance_start_at','phone', 'fb', 'tw'];

}
