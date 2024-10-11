<?php

namespace App\Http\Controllers\Api\Ajax\Transations\Banks;

use Illuminate\Http\Request;
use App\Models\Transactions\Bank;
use App\Http\Controllers\Controller;

class BanksController extends Controller
{


    public function __construct(Request $request,protected $perm = "banks")
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

    public function names()
    {
        $data = [];
        foreach (Bank::pluck("name","id")->toArray() as $id => $name)
            $data[] = ['id' => $id, 'text' => $name];
        return json($data);
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
