<?php

namespace App\Http\Controllers\Api\Ajax\Transations\Receipts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transactions\CatchPurchase;

class PurchasesReceiptsController extends Controller
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
            return datatables()->of(CatchPurchase::latest()->get())
                ->addIndexColumn()
                ->addColumn("number",function ($data){
                    return $data->invoices?->code;
                })
                ->addColumn("price",function ($data){
                    return currency($data->invoices?->price);
                })
                ->addColumn("paid",function ($data){
                    return currency($data->invoices?->totalPaid() ?: $data->client?->totalPaid() );
                })
                ->addColumn("remaining",function ($data){
                    $re = $data->invoices?->remaining();
                    return currency($re ? removeMines($re): $data->client?->remaining());
                })
                ->addColumn("percentage",function ($data){
                    $totalPaid = $data->invoices?->totalPaid() ?: $data->client?->totalPaid();
                    $percentage = (removeMines($totalPaid) * 100) / ($data->invoices?->price ?: ($data->client?->remaining() ?: 1) );
                    return intval($percentage);
                })
                ->addColumn("date",function ($data){
                    return $data->created_at?->format("Y-m-d h:i:s");
                })
                ->addColumn('action', function($data){
                    $btn =  $this->btnPaid($data);
                    return $btn .= $this->btnPrint($data);
                })
                ->rawColumns(['action','percentage'])
                ->make(true);
    }


    private function btnPaid($data)
    {
        if (!$data->client?->remaining()){
            return "";
        }
        $trans = trans("transactions/payments.paid");
        if ($data->invoice_id){
            return "<button class='btn btn-info btn-update'
                    data-id='$data->id'
                    data-invoice-id='{$data->invoice_id}'
                    data-bill-code='{$data->invoices?->code}'
                    data-price='{$data->invoices?->price}'
                    data-client='{$data->invoices?->client?->name}'
                    data-remaining='{$data->invoices?->remaining()}'
                    title='$trans'
                    ><i class='fa fa-hand-holding-usd'></i> $trans</button>";
        }else{
            return "<button class='btn btn-info btn-update'
                    data-id='$data->id'
                    data-invoice-id='{$data->client_id}'
                    data-bill-code='{$data->client?->code}'
                    data-price='0'
                    data-client='{$data->client?->name}'
                    data-remaining='{$data->client?->remaining()}'
                    title='$trans'
                    ><i class='fa fa-hand-holding-usd'></i> $trans</button>";
        }

    }

    private function btnPrint($data)
    {
        $url = route("ajax.transactions.receipts.print",$data->id);
        $trans = trans("home.print");
        return "<a class='btn btn-info ' href='$url' title='$trans'><i class='fa fa-print'></i> $trans</a>";
    }
}
