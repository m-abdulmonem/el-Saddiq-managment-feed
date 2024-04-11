<?php

namespace App\Http\Controllers\Api\Ajax\Transations\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transactions\Payments;

class PrintPaymentController extends Controller
{

    public function __construct(protected $folder = "site.transactions.payments",protected $trans = "transactions/payments")
    {

    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Payments $payment)
    {
        $data = [
            'trans' => $this->trans,
            'payment' => $payment,
        ];

        return view("$this->folder.print.payment_voucher",$data);    }
}
