<?php

namespace App\Http\Middleware;

use App\Services\User\UserServices;
use Illuminate\Http\Request;
use Closure;

class CheckForAttendance
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        UserServices::isAttended();

        return $next($request);
    }
}
