<?php

namespace App\Http\Controllers\Api\Ajax\Dailies;

use App\Models\Dailies\Daily;
use App\Http\Controllers\Controller;
use App\Services\Clients\bills\InvoicesServices;
use App\Http\Requests\Api\Dailies\ValidateBalanceRequest;

class CloseDailyController extends Controller
{

    public function __construct(private ValidateBalanceRequest $request, private Daily $daily)
    {

    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Daily $daily)
    {
        $update = $daily->today()?->update($this->data());

        if ($update) {

            return jsonSuccess("", route("ajax.dailies.print"));
        }

        return jsonError(trans("$this->trans.alert_daily_not_saved"));

    }
    //     public function close(Daily $daily, InvoicesServices $invoice)
//     {
//    }

    private function data()
    {
        $net = $this->daily->netSales();

        return [
            'net_sales' => $net,
            'inc_dec' => ($this->request->balance - $net),
            'time_out' => now()
        ];
    }
}
