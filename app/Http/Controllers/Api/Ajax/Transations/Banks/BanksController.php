<?php

namespace App\Http\Controllers\Api\Ajax\Transations\Banks;

use Illuminate\Http\Request;
use App\Models\Transactions\Bank;
use App\Http\Controllers\Controller;

class BanksController extends Controller
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
        return datatables()->of(Bank::latest()->get())
            ->addIndexColumn()
            ->addColumn("opening_balance", function ($data) {
            return currency($data->opening_balance);
        })
            ->addColumn('action', function ($data) {
            $btn = $this->btnCharts($data);
            $btn .= $this->btnUpdate($data);
            $btn .= btn_delete($this->perm, "banks", $data);
            return $btn;
        })
            ->rawColumns(['action'])
            ->make(true);
    }
}
