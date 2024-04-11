<?php

namespace App\Http\Controllers\Api\Ajax\Transations\Expenses;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transactions\Expenses;

class ExpensesController extends Controller
{
    protected $trans = "transactions/expenses";
    protected $perm = "banks"

    ;
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
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return datatables()->of(Expenses::latest()->get())
            ->addIndexColumn()
            ->addColumn("code", function ($data) {
            return num_to_ar($data->code);
        })
            ->addColumn('action', function ($data) {
            $btn = $this->btnUpdate($data);

            $btn .= btn_delete($this->perm, "expenses", $data);
            return $btn;
        })
            ->rawColumns(['action', 'name'])
            ->make(true);
    }


    private function btnUpdate($data)
    {
        $perm = user_can("read $this->perm") ? "btn-update" : "disabled";

        return "<button class='btn btn-info $perm' data-id='$data->id' data-name='$data->name'><i class='fa fa-edit'></i></button>";
    }
}
