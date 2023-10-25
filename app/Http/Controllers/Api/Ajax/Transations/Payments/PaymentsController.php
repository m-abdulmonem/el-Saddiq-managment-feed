<?php

namespace App\Http\Controllers\Api\Ajax\Transations\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transactions\Payments;

class PaymentsController extends Controller
{

    public function __construct(protected $trans = "transactions/payments")
    {

    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return datatables()->of( Payments::latest()->get())
        ->addIndexColumn()
        ->addColumn("payment",function ($data){
            return trans("$this->trans.$data->payment_type");
        })
        ->addColumn("paid",function ($data){
            return currency($data->paid);
        })
        ->addColumn("date",function ($data){
            return $data->created_at->format("Y-m-d h:i:s");
        })
        ->addColumn('action', function($data){
            return $this->btnPrint($data);
        })
        ->rawColumns(['action'])
        ->make(true);
    }



    private function btnPrint($data)
    {
        $url = route("ajax.transactions.payments.print",$data->id);
        $trans = trans("home.print");
        return "<a class='btn btn-info ' href='$url' title='$trans'><i class='fa fa-print'></i> $trans</a>";
    }
}
