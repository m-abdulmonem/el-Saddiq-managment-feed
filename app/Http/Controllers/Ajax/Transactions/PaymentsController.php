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
        if (request()->ajax())
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

    public function purchases(Request $request)
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
                    $bill = BillServices::find($data->bill_id);
                    $percentage = (removeMines($bill->balances()->where("type",'payment')->sum("paid")) * 100) / $bill->price;
                    return  $this->percentage(intval($percentage));
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

    public function returned(Request $request)
    {
        if (request()->ajax())
            return datatables()->of( Payments::whereNotNull("client_bill_id")->latest()->get())
                ->addIndexColumn()
                ->addColumn("number",function ($data){
                    return $this->clientBillReturn($data,'code');
                })
                ->addColumn("price",function ($data){
                    return currency($this->clientBillReturn($data,'price'));
                })
                ->addColumn("paid",function ($data){
                    if ($bill = InvoicesServices::find($data->client_bill_id))
                        return currency($bill->totalPaid("payment"));
                })
                ->addColumn("remaining",function ($data){
                    return currency(InvoicesServices::find($data->client_bill_id)->remainingBalance());
                })
                ->addColumn("percentage",function ($data){
                    if ($bill = InvoicesServices::find($data->client_bill_id)) {
                        $percentage = (removeMines($bill->totalPaid("payment")) * 100) / $this->clientBillReturn($data,'price');
                        return $this->percentage(intval($percentage));
                    }
                })
                ->addColumn("date",function ($data){
                    return $data->created_at->format("Y-m-d h:i:s");
                })
                ->addColumn('action', function($data){
                    return $this->btnClientPaid($data);
                })
                ->rawColumns(['action','percentage'])
                ->make(true);
    }

    
    public function print(Payments $payment)
    {
        $data = [
            'trans' => $this->trans,
            'payment' => $payment,
        ];
        return view("$this->folder.print.payment_voucher",$data);
    }

    private function clientBill($data)
    {
        return ClientBill::find($data->client_bill_id);
    }
    private function clientBillReturn($data,$property = null)
    {
        return (($bill = $this->clientBill($data))&& $property )?$bill->invoices()->latest()->first()->$property : null;
    }

    private function percentage($percentage)
    {
        return "<div class='progress'><div class='progress-bar' role='progressbar' style='width: $percentage%;' aria-valuenow='$percentage' aria-valuemin='0' aria-valuemax='100'>$percentage%</div></div>";
    }

    private function btnClientPaid($data)
    {
        $trans = trans("$this->trans.paid");
        $bill = InvoicesServices::find($data->client_bill_id);
        return "<button class='btn btn-info btn-update' 
                        data-id='$data->id'
                        data-bill-id='{$data->client_bill_id}'
                        data-bill-code='{$this->clientBillReturn($data,"code")}'
                        data-price='{$this->clientBillReturn($data,"price")}'
                        data-supplier='{$bill->client->name}'
                        data-remaining='{$bill->remainingBalance()}'
                        title='$trans'><i class='fa fa-hand-holding-usd'></i> $trans</button>";
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

    private function btnPrint($data)
    {
        $url = route("ajax.transactions.payments.print",$data->id);
        $trans = trans("home.print");
        return "<a class='btn btn-info ' href='$url' title='$trans'><i class='fa fa-print'></i> $trans</a>";
    }
}
