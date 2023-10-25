<?php

namespace App\Http\Controllers\Api\Ajax\Clients;

use Illuminate\Http\Request;
use App\Models\Chick\ChickOrder;
use App\Http\Controllers\Controller;
use App\Services\Balances\ClientServices;

class ClientBalancesController extends Controller
{


    public function __construct(
        private ClientServices $clientServices,
        private ChickOrder $order,
        private $data,
        private Request $request
        ){

        if ($request->ajax()) {
            \abort(404);
        }

        $data = $request->data == "chick-order-balance"
            ? $this->clientServices->byOrders($request)
            : $this->clientServices->byBooking($order);
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return datatables()->of($this->data)
            ->addIndexColumn()
            ->addColumn("client", function ($data) {
            return $this->clientLink($data);
        })
            ->addColumn("transaction", function ($data) {
            return $data->name();
        })
            ->addColumn("paid", function ($data) {
            return currency($data->paid);
        })
            ->addColumn("rest", function ($data) {
            return currency($data->remaining_amount);
        })
            ->addColumn("date", function ($data) {
            return $data->created_at->diffForHumans();
        })
            ->addColumn("user", function ($data) {
            return userLink($data);
        })
            ->rawColumns(['client', 'user'])
            ->make(true);
    }

    /**
     * redirect route to Supplier page profile
     *
     * @param $data
     * @return string
     */
    private function clientLink($data)
    {
        $route = route("clients.show", $data->clients->id);
        
        return "<a class='info-color' href='$route'>{$data->clients->name()}</a>";
    }


}
