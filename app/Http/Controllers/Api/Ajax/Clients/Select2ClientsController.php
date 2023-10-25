<?php

namespace App\Http\Controllers\Api\Ajax\Clients;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Clients\ClientsServices;
use App\Models\Client\Client;

class Select2ClientsController extends Controller
{

    public function __construct(private Request $request,private ClientsServices $clients)
    {

    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        $callback = function($client){
            return [
                'id' => $client->id,
                'text' => $client->name(),
                'phone' => $client->phone,
                'credit'=> $client->credit_limit,
                'remaining' => ($client->credit_limit - $client->creditor()),
                'limit'=> $client->maximum_repayment_period
            ];
        };



        return json($this->query()->get()->map($callback)->toArray());
    }

    private function query()
    {
        if ($keywords = $this->request->keywords){
            return ClientsServices::search($keywords);
            // return json(->map($callback)->toArray());
        }

        return $this->clients->take($this->request->pagination ?: 10);
    }

}
