<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{


    public function send()
    {

    }


    public function provider() : string
    {

        return $this->initProvider();
    }

    public function initProvider(): string
    {
        $token = env("NOTIFY_TOKEN");
        $key = env("NOTIFY_KEY");
        return match (env('NOTIFY_PROVIDER')) {
            "a" => "a",
            "b" => "b",
            "c" => "c",
            "d" => "d",
            default => "q",
        };
    }



}
