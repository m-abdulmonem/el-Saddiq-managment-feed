<?php


use Illuminate\Support\Facades\Route;

//
//Route::group(['middleware'=>'can:read client','namespace'=>'Clients'],function (){
//
//    Route::resource("/","ClientsController");
//
//    Route::group(['prefix' => 'clients'],function (){
//
//        Route::resource("balances","ClientBalancesController")
//            ->middleware("can:read client_balance");
//
//        Route::group([],function (){
//            Route::resource("sales","ClientsBillsController")
//                ->middleware("can:read client_bill");
//
//            Route::get("bill/{client}/sales/","ClientsBillsController@index")
//                ->middleware("can:read client_bill")->name("sales.client.index");
//
//        });
//    });
//});





//Route::get("client/transactions/{client_id}","ClientsController@transactions")
//    ->name("client.transaction")->middleware("can:read client_balance");
//
//Route::get("ajax/clients","ClientsController@all")
//    ->name("ajax.clients")->middleware("can:read client");
//
//Route::get("ajax/clients/index","ClientsController@ajaxIndex")
//    ->name("ajax.clients.index")->middleware("can:read client");
//
//Route::get("ajax/clients/{keyword}/search","ClientsController@ajaxClientsSearch")
//    ->name("ajax.clients.search")->middleware("can:read client");
//
//Route::get("ajax/client/{id}","ClientsController@ajaxData")
//    ->name("ajax.client.data")->middleware("can:read client");
