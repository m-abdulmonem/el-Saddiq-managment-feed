<?php

namespace App\Http\Controllers\Ajax\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\Expenses;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    protected $trans = "transactions/expenses";
    protected $perm = "expenses";

    public function index(Request $request)
    {
        if (request()->ajax())
            return datatables()->of( Expenses::latest()->get())
                ->addIndexColumn()
                ->addColumn("code",function ($data){
                    return num_to_ar($data->code);
                })
                ->addColumn('action', function($data){
                    $btn = $this->btnUpdate($data);

                    $btn .= btn_delete($this->perm,"expenses",$data);
                    return $btn;
                })
                ->rawColumns(['action','name'])
                ->make(true);
    }

    public function names()
    {
        $data = [];
        foreach (Expenses::pluck("name","id")->toArray() as $id => $name)
            $data[] = ['id' => $id, 'text' => $name];
        return json($data);
    }


    private function btnUpdate($data)
    {
        $perm = user_can("read $this->perm") ? "btn-update" : "disabled";

        return "<button class='btn btn-info $perm' data-id='$data->id' data-name='$data->name'><i class='fa fa-edit'></i></button>";
    }
}
