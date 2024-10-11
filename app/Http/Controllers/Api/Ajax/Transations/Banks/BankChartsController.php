<?php

namespace App\Http\Controllers\Api\Ajax\Transations\Banks;

use Illuminate\Http\Request;
use App\Models\Transactions\Bank;
use App\Http\Controllers\Controller;

class BankChartsController extends Controller
{


    public function __construct(   Request $request,protected $perm = "banks")
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
            ->addColumn("date", function ($data) {
            return $data->created_at->format("Y-m-d H:i:s");
        })
            ->addColumn("statement", function ($data) {
            return "-";
        })
            ->addColumn("creditor", function ($data) {
            return "-";
        })
            ->addColumn("debtor", function ($data) {
            return "-";
        })
            ->addColumn('action', function ($data) {
            $btn = $this->btnUpdate($data);
            $btn .= $this->btnCharts($data);
            $btn .= btn_delete($this->perm, "banks", $data);
            return $btn;
        })
            ->rawColumns(['action'])
            ->make(true);
    }


    private function btnCharts($data)
    {
        return "<button class='btn btn-info btn-chart ' data-id='$data->id' data-name='$data->name' ><i class='fa fa-chart-bar'></i></button>";
    }
    private function btnUpdate($data)
    {
        $perm = user_can("read $this->perm") ? "btn-update" : "disabled";

        return "<button class='btn btn-info $perm'
                        data-id='$data->id'
                        data-name='$data->name'
                        data-address='$data->address'
                        ><i class='fa fa-edit'></i></button>";
    }
}
