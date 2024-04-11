<?php

namespace App\Http\Controllers\Api\Ajax\Transations\Banks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transactions\Bank;

class Select2BanksController extends Controller
{

    public function __construct(protected $perm = "banks",Request $request)
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
        $callback = function ($bank) {
            return [
                'id' => $bank->id,
                'text' => $bank->name,
            ];
        };

        return json(Bank::pluck("name", "id")->map($callback)->toArray());
    }
}
