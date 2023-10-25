<?php

namespace App\Http\Controllers\Ajax\Transactions\Receipts;

use App\Http\Controllers\Controller;
use App\Models\Transactions\CatchPurchase;
use App\Services\Clients\bills\InvoicesServices;
use App\Services\Supplier\Bills\BillServices;
use Illuminate\Http\Request;

class ReceiptsController extends Controller
{
    protected $folder = "site.transactions.receipts";
    protected $trans = "transactions/receipts";
    protected $perm = "receipts";

    // public function purchases()
    // {
    //     if (request()->ajax())
    //         return datatables()->of(CatchPurchase::whereNotNull("invoice_id")->latest()->get())
    //             ->addIndexColumn()
    //             ->addColumn("number",function ($data){
    //                 return $data->invoices->code;
    //             })
    //             ->addColumn("price",function ($data){
    //                 return currency($data->invoices->price);
    //             })
    //             ->addColumn("paid",function ($data){
    //                 return currency($data->invoices->totalPaid());
    //             })
    //             ->addColumn("remaining",function ($data){
    //                 return currency(removeMines($data->invoices->remaining()));
    //             })
    //             ->addColumn("percentage",function ($data){
    //                 $percentage = (removeMines($data->invoices->totalPaid()) * 100) / $data->invoices->price;
    //                 return  $this->percentage(intval($percentage));
    //             })
    //             ->addColumn("date",function ($data){
    //                 return $data->created_at->format("Y-m-d h:i:s");
    //             })
    //             ->addColumn('action', function($data){
    //                 $btn =  $this->btnPaid($data);
    //                 return $btn .= $this->btnPrint($data);
    //             })
    //             ->rawColumns(['action','percentage'])
    //             ->make(true);
    // }

    public function returned(Request $request)
    {
        // if (request()->ajax())
        //     return datatables()->of( CatchPurchase::whereNotNull("bill_id")->latest()->get())
        //         ->addIndexColumn()
        //         ->addColumn("number",function ($data){
        //             return $data->bills->code;
        //         })
        //         ->addColumn("price",function ($data){
        //             return currency($data->bills->price);
        //         })
        //         ->addColumn("paid",function ($data){
        //             return currency($data->bills->totalPaid());
        //         })
        //         ->addColumn("remaining",function ($data){
        //             return currency(removeMines($data->bills->totalPaid() - $data->bills->price));
        //         })
        //         ->addColumn("percentage",function ($data){
        //             $percentage = (removeMines($data->bills->totalPaid()) * 100) / $data->bills->price;
        //             return $this->percentage(intval($percentage));
        //         })
        //         ->addColumn("date",function ($data){
        //             return $data->created_at->format("Y-m-d h:i:s");
        //         })
        //         ->addColumn('action', function($data){
        //             return $this->btnSupplierPaid($data);
        //         })
        //         ->rawColumns(['action','percentage'])
        //         ->make(true);
    }
    public function print(CatchPurchase $receipt)
    {
        $data = [
            'trans' => $this->trans,
            'payment' => $receipt,
        ];
        return view("$this->folder.print.receipts",$data);
    }



}
