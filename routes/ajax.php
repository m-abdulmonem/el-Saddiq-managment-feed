<?php


use App\Http\Controllers\Ajax\Categories\CategoriesController;
use App\Http\Controllers\Ajax\Jobs\JobsController;
use App\Http\Controllers\Ajax\Products\MedicinesController;
use App\Http\Controllers\Ajax\Users\UsersControllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ajax\Stocks\StocksController;
use App\Http\Controllers\Ajax\Clients\ClientsController;
use App\Http\Controllers\Ajax\Suppliers\BillsController;
use App\Http\Controllers\Ajax\Clients\InvoicesControllers;
use App\Http\Controllers\Ajax\Products\ProductsController;
use App\Http\Controllers\Ajax\Suppliers\SuppliersController;
use App\Http\Controllers\Api\Ajax\Dailies\DailiesController;
use App\Http\Controllers\Api\Ajax\Dailies\CloseDailyController;
use App\Http\Controllers\Api\Ajax\Dailies\PrintDailyController;
use App\Http\Controllers\Api\Ajax\Clients\Select2ClientsController;
use App\Http\Controllers\Api\Ajax\Transations\Banks\BanksController;
use App\Http\Controllers\Api\Ajax\Transations\Banks\BankChartsController;
use App\Http\Controllers\Api\Ajax\Transations\Expenses\ExpensesController;
use App\Http\Controllers\Api\Ajax\Transations\Payments\PaymentsController;
use App\Http\Controllers\Api\Ajax\Transations\Banks\Select2BanksController;
use App\Http\Controllers\Api\Ajax\Transations\Payments\PrintPaymentController;
use App\Http\Controllers\Api\Ajax\Transations\Receipts\PrintReceiptsController;
use App\Http\Controllers\Api\Ajax\Transations\Expenses\Select2ExpensesController;
use App\Http\Controllers\Api\Ajax\Transations\Payments\ReturnedPaymentsController;
use App\Http\Controllers\Api\Ajax\Transations\Receipts\ReturnedReceiptsController;
use App\Http\Controllers\Api\Ajax\Transations\Payments\PurchasesPaymentsController;
use App\Http\Controllers\Api\Ajax\Transations\Receipts\PurchasesReceiptsController;


Route::group([], function () {
    //balances
    // Route::group(['prefix'=>'balances','namespace'=>'Balances'],function (){

    //     //chicks balances
    //     Route::group(['prefix'=>'chick'],function (){

    //         Route::get("supplier/{id?}","AjaxBalancesController@chickSupplier")
    //             ->name("ajax.balances.chick.supplier")->middleware("can:read chick");

    //         Route::get("client/{order?}","AjaxBalancesController@client")
    //             ->name("ajax.balances.chick.client")->middleware("can:read chick");

    //     });

    // });


    //chicks
    // Route::group(['prefix'=>'chick','as'=>'ajax.chicks.','middleware'=>['permission:read chick|chick_order|chick_booking']], function (){

    //     Route::get("/","ChicksController@index")->name("index");

    //     //graph
    //     Route::group(['prefix' => 'graph','as' =>'graph.'],function (){
    //         Route::get("prices/{chick}","ChicksController@prices")->name("prices");
    //         Route::get("locations/{chick}","ChicksController@locations")->name("locations");
    //         Route::get("consumption/{chick}","ChicksController@consumptionGraph")->name("consumption");
    //         Route::get("income/statement/{chick}","ChicksController@incomeStatementGraph")->name("income.statement");
    //     });

    //     //orders
    //     Route::group(['prefix'=>'orders','as'=> 'orders.','middleware' => ['permission:read chick_order']],function (){

    //         Route::get("/","OrdersController@index")->name("index");

    //         Route::put("{order}/arrived","OrdersController@arrived")->name("arrived");

    //         Route::put("arrive/{order}/date","OrdersController@arrivedAt")->name("arrive.date");

    //         Route::put("request/{order}","OrdersController@requestOrder")->name("request");
    //         //balances
    //         Route::group(['prefix'=>'balances','as' => 'balances.'],function (){
    //             Route::get("/{order}/supplier","OrdersController@supplierBalances")->name("supplier");
    //             Route::get("/{order}/client","OrdersController@clientBalances")->name("client");
    //         });
    //     });

    //     //booking
    //     Route::group(['middleware' => ['permission:read chick_booking'],'prefix'=>'booking'],function (){

    //         Route::get("/","BookingController@index")->name("ajax.booking.index");

    //         Route::put("reservations/{id}/order","BookingController@orderReservations")->name("chick.reservations.order");

    //         Route::get("transaction/{booking}/","BookingController@transaction")->name("ajax.chick.booking.transaction");

    //         Route::put("delivered/{booking}","BookingController@delivered")->name("ajax.chick.booking.delivered");

    //         Route::get("resend/{booking}","BookingController@resendSms")->name("ajax.chick.booking.resend.sms");
    //     });

    //     //balances
    //     Route::group(['prefix'=>'balances'],function (){
    //         Route::get("{chick}/supplier","ChicksController@supplierBalances")->name("ajax.chicks.balances.supplier");
    //         Route::get("{chick}/client","ChicksController@clientBalances")->name("ajax.chicks.balances.client");
    //     });

    // });

    // //clients
    Route::group(['prefix' => 'client', 'middleware' => ['permission:read client|client_bill'], 'as' => 'ajax.clients.'], function () {

        Route::group(['prefix' => 'invoices', 'middleware' => ['permission:read client_bill'], 'as' => 'invoices.'], function () {
            Route::controller(InvoicesControllers::class)->group(function () {
                Route::get("/", 'index')->name("index");
                Route::get("balances/{invoice}", "balances")->name("balances");
                Route::get("products/{invoice}", "products")->name("products");
                Route::get("returnedInvoices/{invoice}", "returnedInvoices")->name("returned.invoices");
                Route::get("names/", "names")->name("names");
                Route::get("returned/names/", "names")->name("returned.names");
                Route::get("codes/", "codes")->name("codes");
                Route::get("returned/invoices/search", "search")->name("ajax/clients/returned/invoices/search");
            });
        });


        //print
        Route::group(['prefix' => 'print', 'as' => 'print.'], function () {
            Route::get("/invoice/{invoice}", [InvoicesControllers::class, 'printInvoice'])->name("invoice");
            Route::get("/invoice", [InvoicesControllers::class,"printLastInvoice"])->name("last.invoice");
            Route::get("/returned/invoice/{invoice}", [InvoicesControllers::class,"printInvoice"])->name("returned.invoice");
            Route::get("/invoice/balance/{invoice}", [InvoicesControllers::class,"printInvoice"])->name("balance");
        });

        Route::controller(ClientsController::class)->group(function () {
            Route::get("/", "index")->name("index");
            Route::get("products/{client}", "products")->name("products");
            Route::get("search/{keyword}", "search")->name("search");

            //balances
            Route::get("/balances/{client}", "balances")->name("balances");

            Route::group(['prefix' => 'graph', 'as' => 'graph.'], function () {
                Route::get("invoices/{client}", "invoicesGraph")->name("invoices");
                Route::get("quantity/{client}", "quantityGraph")->name("quantity");
                Route::get("consumption/{client}", "consumptionGraph")->name("consumption");
                Route::get("booking/{client}", "bookingGraph")->name("booking");
                Route::get("booking/quantity/{client}", "bookingQuantityGraph")->name("booking.quantity");
                Route::get("chicks/consumption/{client}", "chicksConsumptionGraph")->name("chicks.consumption");
                Route::get("income/statement/{client}", "gainLossGraph")->name("income.statement");
            }
            );
        }
        );

        Route::get("names", Select2ClientsController::class)->name("names");
    });

    //products
    Route::group(['prefix' => 'products', 'middleware' => ['permission:read product'], 'as' => 'ajax.products.'], function () {

        Route::controller(ProductsController::class)->group(function () {
            Route::get("/", "index")->name("index");
            Route::get("search", "search")->name("search");
            Route::get("search/name", "searchName")->name("search.name");
            Route::put("price/change/{product}", "updatePrice")->name("price.update");


            Route::group(['prefix' => 'graph', 'as' => 'graph.'], function () {
                Route::get("location/{product}", "locationsGraph")->name("locations");
                Route::get("consumption/{product}", "consumptionGraph")->name("consumption");
                Route::get("prices/{product}", "pricesGraph")->name("prices");
                Route::get("income/statement/{product}", "incomeStatementGraph")->name("income.statement");
            }
            );

            Route::group(['prefix' => 'selectors'], function () {
                Route::get("units", "units")->name("units");
                Route::get("suppliers", "suppliers")->name("suppliers");
                Route::get("categories", "categories")->name("categories");
            }
            );
        }
        );


        Route::group(['prefix' => 'medicines', 'as' => 'medicines.'], function () {
            Route::get("/", [MedicinesController::class,"index"])->name("index");
            Route::put("/purchases/", [MedicinesController::class,"purchases"])->name("purchases");
            Route::put("/sell", [MedicinesController::class,"sell"])->name("sell");
            Route::get("/search", [MedicinesController::class,"search"])->name("search");
        }
        );


    }
    );

    //graph
    // Route::group(['prefix' => 'graph'],function (){
    //     //chicks
    //     Route::group(['prefix' => 'chicks','namespace'=>'Chicks'],function (){
    //         Route::get("prices/{chick}","GraphController@prices")->name("ajax.graph.chicks.prices");
    //         Route::get("locations/{chick}","GraphController@locations")->name("ajax.graph.chicks.locations");
    //         Route::get("consumption/{chick}","GraphController@consumption")->name("ajax.graph.chicks.consumption");
    //     });

    //     Route::group(['prefix' => 'stocks','namespace'=>'Stocks'],function (){
    //         Route::get("Products/top/{stock}","GraphController@topProducts")->name("ajax.graph.stocks.top.products");
    //         Route::get("locations/{stock}","GraphController@locations")->name("ajax.graph.stocks.locations");
    //         Route::get("consumption/{stock}","GraphController@consumption")->name("ajax.graph.stocks.consumption");
    //     });


    // });

    //category
    Route::group(['prefix' => 'categories', 'as' => 'ajax.categories.', 'middleware' => ['permission:read category']], function () {
        Route::get("/", [CategoriesController::class, "index"])->name("index");
    }
    );

    //stocks
    Route::group(['prefix' => 'stocks', 'as' => 'ajax.stocks.', 'middleware' => ['permission:read stock']], function () {
        Route::get("/", [StocksController::class])->name("index");
        Route::get("/list", [StocksController::class, "list"])->name("list");
        Route::get("/names", [StocksController::class, "names"])->name("names");

        Route::put("product/{pivot}/move", [StocksController::class,"move"])->name("product.move");

        Route::group(['prefix' => 'charts'], function () {
            Route::get("consumption/{stock}", [StocksController::class,"consumptionGraph"])->name("graph.consumption");
            Route::get("products/{stock}", [StocksController::class,"productsGraph"])->name("graph.products");
            Route::get("location/{stock}", [StocksController::class,"locationsGraph"])->name("graph.location");
        }
        );

        Route::group(['prefix' => 'print'], function () {
            Route::get("stocktaking/{stock}", "StocksController@stocktaking")->name("print.stocktaking");
        }
        );
    }
    );

    //users
    Route::group(['prefix' => 'users',  'middleware' => ['permission:read user']], function () {
        Route::get("/", [UsersControllers::class,"index"])->name("ajax.users.index");
        Route::post("attendance/{user}", [UsersControllers::class,"attendance"])->name("ajax.users.attendance");
        Route::put("departure/{user}", [UsersControllers::class,"departure"])->name("ajax.users.departure");

        Route::put("/mark/notification/{notify}", [UsersControllers::class,"markNotification"])->name("ajax.users.mark");
        Route::get("expired/notifications", [UsersControllers::class,"notifications"])->name("ajax.users.expired.notifications");

        Route::group(['prefix' => 'balances'], function () {
            Route::get("client/{user}", [UsersControllers::class,"clientBalances"])->name("ajax.users.balances.client");
            Route::get("supplier/{user}", [UsersControllers::class,"supplierBalances"])->name("ajax.users.balances.supplier");
        }
        );
    }
    );
    //jobs
    Route::group(['prefix' => 'jobs',  'middleware' => ['permission:read job']], function () {
        Route::get("/", [JobsController::class,"index"])->name("ajax.jobs.index");
    }
    );

    //suppliers
    Route::group(['prefix' => 'suppliers', 'as' => "ajax.suppliers.", 'middleware' => ['permission:read supplier|supplier_bill']], function () {
        Route::get("/", [SuppliersController::class, 'index'])->name("index");
        Route::get("/balances/{supplier}", [SuppliersController::class, 'balances'])->name("balances");

        //graph
        Route::group(['prefix' => 'graph'], function () {
            //'SuppliersController@quantityGraph'
            Route::get("quantity/{supplier}", [SuppliersController::class, 'quantityGraph'])->name("graph.quantity");
            Route::get("bills/{supplier}", [SuppliersController::class, 'billsGraph'])->name("graph.bills");

            Route::get("products/{supplier}", [SuppliersController::class,'productsGraph'])->name("graph.products");
            Route::get("chicks/quantity/{supplier}", [SuppliersController::class,'chicksQuantityGraph'])->name("graph.chicks.quantity");
            Route::get("chicks/{supplier}", [SuppliersController::class,'chicksGraph'])->name("graph.chicks");
            Route::get("orders/{supplier}", [SuppliersController::class,'ordersGraph'])->name("graph.orders");
            Route::get("income/statement/{supplier}", [SuppliersController::class,'incomeStatementGraph'])->name("graph.income.statement");
        }
        );
        //bills
        Route::group(['prefix' => 'bills', 'as' => 'bills.', 'middleware' => ['permission:read supplier_bill']], function () {
            Route::get("/", [BillsController::class, 'index'])->name("index");
            Route::get("/balances/{bill}", [BillsController::class, 'balances'])->name("balances");
            Route::get("/products/{bill}", [BillsController::class, 'products'])->name("products");
            Route::get("returned/products/{bill}", "BillsController@returnedProducts")->name("returned.products");
            Route::get("names/", [BillsController::class, 'names'])->name("names");
            Route::get("returned/codes", "BillsController@codes")->name("returned.codes");
        }
        );

        Route::group(['prefix' => 'print'], function () {

            Route::get("transaction/{bill}", [BillsController::class,"printTransaction"])->name("print.transactions");
        }
        );

    }
    );

    //transactions
    Route::group(["as" => "ajax.transactions."], function () {
        Route::group(['prefix' => 'expenses', 'as' => 'expenses.'], function () {

            Route::get("/", ExpensesController::class)->name("index");

            Route::get("names", Select2ExpensesController::class)->name("names");
        }
        );

        Route::group(['prefix' => 'payments', 'as' => 'payments.'], function () {
            Route::get("/", PaymentsController::class)->name("index");

            Route::get("purchases", PurchasesPaymentsController::class)->name("purchases");

            Route::get("returned", ReturnedPaymentsController::class)->name("returned");

            Route::get("print/{payment}", PrintPaymentController::class)->name("print");
        }
        );

        Route::group(['prefix' => 'receipts', 'as' => 'receipts.'], function () {
            Route::get("/", PurchasesReceiptsController::class)->name("index");

            Route::get("returned", ReturnedReceiptsController::class)->name("returned");

            Route::get("print/{receipt}", PrintReceiptsController::class)->name("print");
        }
        );


        Route::group(['prefix' => 'banks', 'as' => 'banks.'], function () {
            Route::get("/", BanksController::class)->name("index");
            Route::get("names", Select2BanksController::class)->name("names");
            Route::get("charts/{bank?}", BankChartsController::class)->name("charts");
            Route::get("print/{bank?}", "BanksController@print")->name("print");
        }
        );
    }
    );

    Route::group(['prefix' => 'dailies', 'as' => 'ajax.dailies.'], function () {
        Route::get("/", DailiesController::class)->name("index");
        Route::put("/close", CloseDailyController::class)->name("close");
        Route::get("/print/", PrintDailyController::class)->name("print");

        Route::get("/logout", function () {
            auth()->logout();
            return redirect()->route("login");
        }
        )->name("logout");

    }  );
});
