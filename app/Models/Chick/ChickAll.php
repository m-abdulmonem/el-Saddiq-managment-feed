<?php

namespace App\Models\Chick;

use App\Models\Supplier\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChickAll extends Model
{
    use SoftDeletes;
    public $timestamps = true;

    protected $table = 'chicks';
    protected $dates = ['deleted_at','arrived_at'];

    protected $fillable = ['name','type','supplier_id'];


    /**
     * One to Many relationship
     *
     * @return BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * @return HasMany
     */
    public function orders()
    {
        return $this->hasMany(ChickOrder::class,"chick_id");
    }

    /**
     * @return HasMany
     */
    public function prices()
    {
        return $this->hasMany(ChickPrice::class, "chick_id");
    }

}
