<?php

namespace App\Http\Controllers\Api\Ajax\Transations\Banks;

use App\Http\Controllers\Controller;
use App\Models\Transactions\Expenses;
use Illuminate\Http\Request;
use App\Models\Transactions\Bank;

class Select2BanksController extends Controller
{
    protected string $perm = "banks";


    public function __construct(Request $request)
    {
        if (!$request->ajax()) {
            \abort(404);
        }
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return
     */
    public function __invoke(Request $request)
    {
//        $callback = function ($bankName,$bankId) {
//            return [
//                'id' => $bankId,
//                'text' => $bankName,
//            ];
//        };
//
//        return json(array_values(Bank::pluck("name", "id")->map($callback)->toArray()));

        $callback = function ($bank) {

            return [
                'id' => $bank->id,
                'text' => $bank->name,
            ];
        };

        return json(Bank::all()->map($callback)->toArray());
    }
}
