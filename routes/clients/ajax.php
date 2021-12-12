<?php

use Illuminate\Support\Facades\Route;



//chicks orders

Route::group([],function (){

    Route::get("clients","ClientsController@index")
        ->name("ajax.clients.index")->middleware("can:read client");

    Route::get("search/{keyword}","ClientsController@search")
        ->name("ajax.clients.search")->middleware("can:read client");


});


