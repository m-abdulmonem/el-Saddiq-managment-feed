<?php

namespace App\Http\Controllers\Api\Ajax\Transations\Receipts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transactions\CatchPurchase;

class PrintReceiptsController extends Controller
{

    public function __construct(
        protected $folder = "site.transactions.receipts",
        protected $trans = "transactions/receipts",
        protected $perm = "receipts"){}
        
    /**
     * Handle the incoming request.
     *
     * @param  CatchPurchase  $receipt
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CatchPurchase $receipt)
    {
        $data = [
            'trans' => $this->trans,
            'payment' => $receipt,
        ];
        return view("$this->folder.print.receipts",$data);
        }
}
