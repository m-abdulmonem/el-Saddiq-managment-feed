<?php

use App\Models\Setting;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use App\Models\Dailies\Daily;
use App\Http\Resources\DailyResource;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\InvoiceResource;
use App\Services\Clients\bills\InvoicesServices;
use App\Http\Requests\Clients\Invoices\CreateRequest;
use App\Http\Controllers\Api\Api\Auth\LoginController;
use App\Http\Controllers\Api\Ajax\Users\UserController;
use App\Http\Controllers\Site\Clients\ClientsController;
use App\Http\Controllers\Site\Clients\InvoicesController;
use App\Http\Controllers\Ajax\Clients\InvoicesControllers;
use App\Http\Controllers\Api\Ajax\Dailies\CloseDailyController;
use App\Http\Controllers\Api\Ajax\Clients\Select2ClientsController;
use App\Http\Controllers\Api\Ajax\Products\Select2ProductsController;
use App\Services\Clients\ClientsServices;

/* |-------------------------------------------------------------------------- | API Routes |-------------------------------------------------------------------------- | | Here is where you can register API routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | is assigned the "api" middleware group. Enjoy building your API! | */


Route::post('login', LoginController::class);


Route::group(['middlware' => 'auth:sanctum'], function () {

    Route::get("profile", UserController::class);


    Route::get("clients/name", Select2ClientsController::class);
    Route::get("products/name", Select2ProductsController::class);

    Route::apiResource("invoices", InvoicesController::class);

    Route::post("client/create", [ClientsController::class , 'store']);

    Route::get("invoice/last", fn() => json( InvoicesServices::latest()->first()->id ));

    Route::get("/invoice/{invoice}/print", fn(InvoicesServices $invoice) => json(new InvoiceResource($invoice)));

    Route::put("daily/close",CloseDailyController::class);

    Route::get("daily/print",fn () => new DailyResource(Daily::latest()->first()) );


    Route::get("test",function ()
    {
        $arr =[];
        foreach (ClientsServices::all() as $client){
           if($balance =  $client->balance()->latest()->first()){

            if ($client->creditor() > 0
                && $balance->created_at->diffInDays(now()) >= $client->maximum_repayment_period) {
                    $arr[]= $balance;
            }else{

            $arr['else'][] = $client->name() . ' ' .$client->creditor();
            }
           }

        }
        return  json($arr);
    });

    Route::get("settings", function () {
            return json(Setting::orderBy('id', 'DESC')->first());
        }
        );
    });
