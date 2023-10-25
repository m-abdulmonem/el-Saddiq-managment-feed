<?php

namespace App\Http\Controllers\Ajax\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Client\ClientBill;
use App\Models\Supplier\SupplierBill;
use App\Models\Transactions\Bank;
use App\Models\Transactions\Payments;
use App\Services\Clients\bills\InvoicesServices;
use App\Services\Supplier\Bills\BillServices;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    protected $folder = "site.transactions.payments";
    protected $trans = "transactions/payments";
    protected $perm = "payments";

    public function index(Request $request)
    {
        // if (request()->ajax())
        //     return datatables()->of( Payments::latest()->get())
        //         ->addIndexColumn()
        //         ->addColumn("payment",function ($data){
        //             return trans("$this->trans.$data->payment_type");
        //         })
        //         ->addColumn("paid",function ($data){
        //             return currency($data->paid);
        //         })
        //         ->addColumn("date",function ($data){
        //             return $data->created_at->format("Y-m-d h:i:s");
        //         })
        //         ->addColumn('action', function($data){
        //             return $this->btnPrint($data);
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
    }

    // public function purchases(Request $request)
    // {
    //     if (request()->ajax())
    //         return datatables()->of( Payments::whereNotNull("bill_id")->latest()->get())
    //             ->addIndexColumn()
    //             ->addColumn("number",function ($data){
    //                 return SupplierBill::find($data->bill_id)->code;
    //             })
    //             ->addColumn("price",function ($data){
    //                 return currency(SupplierBill::find($data->bill_id)->price);
    //             })
    //             ->addColumn("paid",function ($data){
    //                 return currency(BillServices::find($data->bill_id)->totalPaid());
    //             })
    //             ->addColumn("remaining",function ($data){
    //                 return currency(removeMines(BillServices::find($data->bill_id)->remainingBalance()));
    //             })
    //             ->addColumn("percentage",function ($data){
    //                 $bill = BillServices::find($data->bill_id);
    //                 $percentage = (removeMines($bill->balances()->where("type",'payment')->sum("paid")) * 100) / $bill->price;
    //                 return  $this->percentage(intval($percentage));
    //             })
    //             ->addColumn("date",function ($data){
    //                 return $data->created_at->format("Y-m-d h:i:s");
    //             })
    //             ->addColumn('action', function($data){
    //                 return $this->btnPaid($data);
    //             })
    //             ->rawColumns(['action','percentage'])
    //             ->make(true);
    // }

    // public function returned(Request $request)
    // {
    //     if (request()->ajax())
    //         return datatables()->of( Payments::whereNotNull("client_bill_id")->latest()->get())
    //             ->addIndexColumn()
    //             ->addColumn("number",function ($data){
    //                 return $this->clientBillReturn($data,'code');
    //             })
    //             ->addColumn("price",function ($data){
    //                 return currency($this->clientBillReturn($data,'price'));
    //             })
    //             ->addColumn("paid",function ($data){
    //                 if ($bill = InvoicesServices::find($data->client_bill_id))
    //                     return currency($bill->totalPaid("payment"));
    //             })
    //             ->addColumn("remaining",function ($data){
    //                 return currency(InvoicesServices::find($data->client_bill_id)->remainingBalance());
    //             })
    //             ->addColumn("percentage",function ($data){
    //                 if ($bill = InvoicesServices::find($data->client_bill_id)) {
    //                     $percentage = (removeMines($bill->totalPaid("payment")) * 100) / $this->clientBillReturn($data,'price');
    //                     return $this->percentage(intval($percentage));
    //                 }
    //             })
    //             ->addColumn("date",function ($data){
    //                 return $data->created_at->format("Y-m-d h:i:s");
    //             })
    //             ->addColumn('action', function($data){
    //                 return $this->btnClientPaid($data);
    //             })
    //             ->rawColumns(['action','percentage'])
    //             ->make(true);
    // }


    // public function print(Payments $payment)
    // {
    //     $data = [
    //         'trans' => $this->trans,
    //         'payment' => $payment,
    //     ];
    //     return view("$this->folder.print.payment_voucher",$data);
    // }





}
