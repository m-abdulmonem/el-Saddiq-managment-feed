<?php

namespace App\Models\Client\Pivot;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClientProductReturn extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    public function stock()
    {
        return $this->belongsTo(Stock::class,"stock_id");
    }
}
