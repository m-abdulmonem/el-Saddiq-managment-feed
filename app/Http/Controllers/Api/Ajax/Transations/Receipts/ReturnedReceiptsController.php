<?php

namespace App\Http\Controllers\Api\Ajax\Transations\Receipts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transactions\CatchPurchase;

class ReturnedReceiptsController extends Controller
{


    public function __construct(
        protected $folder = "site.transactions.receipts",
        protected $trans = "transactions/receipts",
        protected $perm = "receipts"){}
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if (request()->ajax())
        return datatables()->of( CatchPurchase::whereNotNull("bill_id")->latest()->get())
            ->addIndexColumn()
            ->addColumn("number",function ($data){
                return $data->bills->code;
            })
            ->addColumn("price",function ($data){
                return currency($data->bills->price);
            })
            ->addColumn("paid",function ($data){
                return currency($data->bills->totalPaid());
            })
            ->addColumn("remaining",function ($data){
                return currency(removeMines($data->bills->totalPaid() - $data->bills->price));
            })
            ->addColumn("percentage",function ($data){
                $percentage = (removeMines($data->bills->totalPaid()) * 100) / $data->bills->price;
                return $this->percentage(intval($percentage));
            })
            ->addColumn("date",function ($data){
                return $data->created_at->format("Y-m-d h:i:s");
            })
            ->addColumn('action', function($data){
                return $this->btnSupplierPaid($data);
            })
            ->rawColumns(['action','percentage'])
            ->make(true);
    }


    private function btnSupplierPaid($data)
    {
        $trans = trans("transactions/payments.paid");
//        data-remaining='{$bill->remainingBalance()}'
        return "<button class='btn btn-info btn-update'
                        data-id='$data->id'
                        data-bill-id='{$data->bill_id}'
                        data-bill-code='{$data->bills->code}'
                        data-price='{$data->bills->price}'
                        data-supplier='{$data->bills->supplier->name}'
                        title='$trans'><i class='fa fa-hand-holding-usd'></i> $trans</button>";
    }
}
