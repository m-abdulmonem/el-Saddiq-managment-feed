<?php

namespace App\Http\Controllers\Api\Ajax\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return (new UserResource(auth('sanctum')->user()))->additional(['code' => 1 ]);
    }
}
