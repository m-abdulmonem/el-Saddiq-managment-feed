<?php

namespace App\Http\Controllers\Api\Ajax\Transations\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Supplier\SupplierBill;
use App\Models\Transactions\Payments;
use App\Services\Supplier\Bills\BillServices;

class PurchasesPaymentsController extends Controller
{
    protected $trans = "transactions/expenses";
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if (request()->ajax())
        return datatables()->of( Payments::whereNotNull("bill_id")->latest()->get())
            ->addIndexColumn()
            ->addColumn("number",function ($data){
                return SupplierBill::find($data->bill_id)->code;
            })
            ->addColumn("price",function ($data){
                return currency(SupplierBill::find($data->bill_id)->price);
            })
            ->addColumn("paid",function ($data){
                return currency(BillServices::find($data->bill_id)->totalPaid());
            })
            ->addColumn("remaining",function ($data){
                return currency(removeMines(BillServices::find($data->bill_id)->remainingBalance()));
            })
            ->addColumn("percentage",function ($data){
                return  $this->percentageHtml(BillServices::find($data->bill_id));
            })
            ->addColumn("date",function ($data){
                return $data->created_at->format("Y-m-d h:i:s");
            })
            ->addColumn('action', function($data){
                return $this->btnPaid($data);
            })
            ->rawColumns(['action','percentage'])
            ->make(true);
    }


    private function percentage($bill)
    {
        $payment = removeMines($bill->balances()->where("type",'payment')->sum("paid"));

        return ($payment * 100) / $bill->price;
    }


    private function percentageHtml($bill)
    {
        $percentage =intval ($this->percentage($bill));
        return "<div class='progress'><div class='progress-bar' role='progressbar' style='width: $percentage%;' aria-valuenow='$percentage' aria-valuemin='0' aria-valuemax='100'>$percentage%</div></div>";
    }

    private function btnPaid($data)
    {
        $trans = trans("$this->trans.paid");
        $bill = BillServices::find($data->bill_id);
        return "<button class='btn btn-info btn-update'
                        data-id='$data->id'
                        data-bill-id='{$data->bill_id}'
                        data-bill-code='{$bill->code}'
                        data-price='{$bill->price}'
                        data-supplier='{$bill->supplier->name}'
                        data-remaining='{$bill->remainingBalance()}'
                        title='$trans'
                        ><i class='fa fa-hand-holding-usd'></i> $trans</button>";
    }
}
