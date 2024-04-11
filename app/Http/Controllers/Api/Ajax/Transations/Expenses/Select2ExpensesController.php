<?php

namespace App\Http\Controllers\Api\Ajax\Transations\Expenses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transactions\Expenses;

class Select2ExpensesController extends Controller
{
    public function __construct(protected $trans = "transactions/expenses", protected $perm = "banks", Request $request)
    {
        if (!$request->ajax()) {
            \abort(404);
        }
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $callback = function ($expense) {
            return [
            'id' => $expense->id,
            'text' => $expense->name,
            ];
        };

        return json(Expenses::pluck("name", "id")->map($callback)->toArray());
    }
}
