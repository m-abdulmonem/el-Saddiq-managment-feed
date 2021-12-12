<?php

namespace App\Http\Middleware;

use App\Models\Client\Client;
use App\Services\Clients\ClientsServices;
use Closure;

class Sms
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //send sms message if client has credit and days limit is greater than
        ClientsServices::creditDaysLimit();

        return $next($request);
    }
}
