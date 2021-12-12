<?php

namespace App\Models\Chick;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChickPrice extends Model
{
    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'chick_prices';
    protected $dates = ['deleted_at'];

    protected $fillable = ['price','chick_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chick()
    {
        return $this->belongsTo(Chick::class);
    }
}
