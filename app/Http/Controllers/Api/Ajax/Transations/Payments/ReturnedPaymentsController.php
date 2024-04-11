<?php

namespace App\Http\Controllers\Api\Ajax\Transations\Payments;

use Illuminate\Http\Request;
use App\Models\Client\ClientBill;
use App\Http\Controllers\Controller;
use App\Models\Transactions\Payments;
use App\Services\Clients\bills\InvoicesServices;
use phpDocumentor\Reflection\Types\Mixed_;

class ReturnedPaymentsController extends Controller
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
        return datatables()->of(Payments::whereNotNull("client_bill_id")->latest()->get())
            ->addIndexColumn()
            ->addColumn("number", function ($data) {
            return $this->clientBillReturn($data, 'code');
        })
            ->addColumn("price", function ($data) {
            return currency($this->clientBillReturn($data, 'price'));
        })
            ->addColumn("paid", function ($data) {
            if ($bill = InvoicesServices::find($data->client_bill_id))
                return currency($bill->totalPaid("payment"));
        })
            ->addColumn("remaining", function ($data) {
            return currency(InvoicesServices::find($data->client_bill_id)->remainingBalance());
        })
            ->addColumn("percentage", function ($data) {
            if ($bill = InvoicesServices::find($data->client_bill_id)) {
                $percentage = (removeMines($bill->totalPaid("payment")) * 100) / $this->clientBillReturn($data, 'price');
                return $this->percentage(intval($percentage));
            }
        })
            ->addColumn("date", function ($data) {
            return $data->created_at->format("Y-m-d h:i:s");
        })
            ->addColumn('action', function ($data) {
            return $this->btnClientPaid($data);
        })
            ->rawColumns(['action', 'percentage'])
            ->make(true);
    }


    private function clientBill($data): ClientBill
    {
        return ClientBill::find($data->client_bill_id);
    }

    private function clientBillReturn($data, $property = null)
    {
        if (($bill = $this->clientBill($data)) && $property) {

            return $bill->invoices()->latest()->first()->$property;
        }
        return null;
    }


    private function btnClientPaid($data)
    {
        $trans = trans("$this->trans.paid");
        $bill = InvoicesServices::find($data->client_bill_id);
        return "<button class='btn btn-info btn-update'
                        data-id='$data->id'
                        data-bill-id='{$data->client_bill_id}'
                        data-bill-code='{$this->clientBillReturn($data, "code")}'
                        data-price='{$this->clientBillReturn($data, "price")}'
                        data-supplier='{$bill->client->name}'
                        data-remaining='{$bill->remainingBalance()}'
                        title='$trans'><i class='fa fa-hand-holding-usd'></i> $trans</button>";
    }

}
