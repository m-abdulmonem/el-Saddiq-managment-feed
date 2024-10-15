<?php

namespace App\Http\Controllers\Api\Ajax\Transations\Expenses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transactions\Expenses;

class Select2ExpensesController extends Controller
{
    protected $trans = "transactions/expenses";
    protected $perm = "banks";
//    public function __construct(Request $request ,protected $trans = "transactions/expenses", protected $perm = "banks")
//    {
//        if (!$request->ajax()) {
//            \abort(404);
//        }
//    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function __invoke(Request $request)
    {
        $callback = function ($expense) {

            return [
            'id' => $expense->id,
            'text' => $expense->name,
            ];
        };

        return json(Expenses::all()->map($callback)->toArray());
    }
}
