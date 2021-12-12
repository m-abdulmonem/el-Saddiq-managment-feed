<?php

namespace App\Http\Controllers\Ajax\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\Bank;
use Illuminate\Http\Request;

class BanksController extends Controller
{
    protected $folder = "site.transactions.banks";
    protected $trans = "transactions/banks";
    protected $perm = "banks";

    public function index(Request $request)
    {
        if (request()->ajax())
            return datatables()->of( Bank::latest()->get())
                ->addIndexColumn()
                ->addColumn("opening_balance",function ($data){
                    return currency($data->opening_balance);
                })
                ->addColumn('action', function($data){
                    $btn = $this->btnCharts($data);
                    $btn .= $this->btnUpdate($data);
                    $btn .= btn_delete($this->perm,"banks",$data);
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function charts(Request $request)
    {
        if (request()->ajax())
            return datatables()->of( Bank::latest()->get())
                ->addIndexColumn()
                ->addColumn("date",function ($data){
                    return $data->created_at->format("Y-m-d H:i:s");
                })
                ->addColumn("statement",function ($data){
                    return "-";
                })
                ->addColumn("creditor",function ($data){
                    return "-";
                })
                ->addColumn("debtor",function ($data){
                    return "-";
                })
                ->addColumn('action', function($data){
                    $btn = $this->btnUpdate($data);
                    $btn .= $this->btnCharts($data);
                    $btn .= btn_delete($this->perm,"banks",$data);
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
