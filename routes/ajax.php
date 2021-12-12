<?php


use Illuminate\Support\Facades\Route;


Route::group([],function (){
    //balances
    Route::group(['prefix'=>'balances','namespace'=>'Balances'],function (){

        //chicks balances
        Route::group(['prefix'=>'chick'],function (){

            Route::get("supplier/{id?}","AjaxBalancesController@chickSupplier")
                ->name("ajax.balances.chick.supplier")->middleware("can:read chick");

            Route::get("client/{order?}","AjaxBalancesController@client")
                ->name("ajax.balances.chick.client")->middleware("can:read chick");

        });

    });


    //chicks
    Route::group(['prefix'=>'chick','namespace'=>'Chicks','middleware'=>['permission:read chick|chick_order|chick_booking']], function (){

        Route::get("/","ChicksController@index")->name("ajax.chicks.index");

        //graph
        Route::group(['prefix' => 'graph'],function (){
            Route::get("prices/{chick}","ChicksController@prices")->name("ajax.chicks.graph.prices");
            Route::get("locations/{chick}","ChicksController@locations")->name("ajax.chicks.graph.locations");
            Route::get("consumption/{chick}","ChicksController@consumptionGraph")->name("ajax.chicks.graph.consumption");
            Route::get("income/statement/{chick}","ChicksController@incomeStatementGraph")->name("ajax.chicks.graph.income.statement");
        });

        //orders
        Route::group(['prefix'=>'orders','middleware' => ['permission:read chick_order']],function (){

            Route::get("/","OrdersController@index")->name("ajax.chick.orders.index");

            Route::put("arrived/{order}","OrdersController@arrived")->name("ajax.chick.order.arrived");
            Route::put("arrive/{order}/date","OrdersController@arrivedAt")->name("ajax.chick.order.arrive.date");

            Route::put("request/{order}","OrdersController@requestOrder")->name("ajax.chick.order.request");
            //balances
            Route::group(['prefix'=>'balances'],function (){
                Route::get("/balances/{order}/supplier","OrdersController@supplierBalances")->name("ajax.chicks.orders.balances.supplier");
                Route::get("/balances/{order}/client","OrdersController@clientBalances")->name("ajax.chicks.orders.balances.client");
            });
        });

        //booking
        Route::group(['middleware' => ['permission:read chick_booking'],'prefix'=>'booking'],function (){

            Route::get("/","BookingController@index")->name("ajax.booking.index");

            Route::put("reservations/{id}/order","BookingController@orderReservations")->name("chick.reservations.order");

            Route::get("transaction/{booking}/","BookingController@transaction")->name("ajax.chick.booking.transaction");

            Route::put("delivered/{booking}","BookingController@delivered")->name("ajax.chick.booking.delivered");

            Route::get("resend/{booking}","BookingController@resendSms")->name("ajax.chick.booking.resend.sms");
        });
        //balances
        Route::group(['prefix'=>'balances'],function (){
            Route::get("/balances/{chick}/supplier","ChicksController@supplierBalances")->name("ajax.chicks.balances.supplier");
            Route::get("/balances/{chick}/client","ChicksController@clientBalances")->name("ajax.chicks.balances.client");
        });

    });

    //clients
    Route::group(['prefix' => 'client','namespace'=>'Clients','middleware'=>['permission:read client|client_bill']],function (){

        Route::group(['prefix' => 'invoices', 'middleware' => ['permission:read client_bill']],function (){
            Route::get("/","InvoicesControllers@index")->name("ajax.clients.invoices.index");
            Route::get("balances/{invoice}","InvoicesControllers@balances")->name("ajax.clients.invoices.balances");
            Route::get("products/{invoice}","InvoicesControllers@products")->name("ajax.clients.invoices.products");
            Route::get("returnedInvoices/{invoice}","InvoicesControllers@returnedInvoices")->name("ajax.clients.invoices.returnedInvoices");
            Route::get("names/","InvoicesControllers@names")->name("ajax.clients.invoices.names");
            Route::get("returned/names/","InvoicesControllers@names")->name("ajax.clients.invoices.returned.names");
            Route::get("codes/","InvoicesControllers@codes")->name("ajax.clients.invoices.codes");
            Route::get("returned/invoices/search","InvoicesControllers@search")->name("ajax/clients/returned/invoices/search");
        });

        Route::group(['prefix' => 'graph'],function (){
            Route::get("invoices/{client}","ClientsController@invoicesGraph")->name("ajax.clients.graph.invoices");
            Route::get("quantity/{client}","ClientsController@quantityGraph")->name("ajax.clients.graph.quantity");
            Route::get("consumption/{client}","ClientsController@consumptionGraph")->name("ajax.clients.graph.consumption");
            Route::get("booking/{client}","ClientsController@bookingGraph")->name("ajax.clients.graph.booking");
            Route::get("booking/quantity/{client}","ClientsController@bookingQuantityGraph")->name("ajax.clients.graph.booking.quantity");
            Route::get("chicks/consumption/{client}","ClientsController@chicksConsumptionGraph")->name("ajax.clients.graph.chicks.consumption");
            Route::get("income/statement/{client}","ClientsController@gainLossGraph")->name("ajax.clients.graph.income.statement");
        });

        //balances
        Route::group(['prefix'=>'balances'],function (){
            Route::get("/balances/{client}","ClientsController@balances")->name("ajax.clients.balances");
        });
        //print
        Route::group(['prefix' => 'print'],function (){
            Route::get("/invoice/{invoice}","InvoicesControllers@printInvoice")->name("ajax.client.print.invoice");
            Route::get("/invoice","InvoicesControllers@printLastInvoice")->name("ajax.client.print.last.invoice");
            Route::get("/returned/invoice/{invoice}","InvoicesControllers@printInvoice")->name("ajax.client.print.returned.invoice");
            Route::get("/invoice/balance/{invoice}","InvoicesControllers@printInvoice")->name("ajax.client.print.balance");
        });
        Route::get("/","ClientsController@index")->name("ajax.clients.index");
        Route::get("products/{client}","ClientsController@products")->name("ajax.clients.products");
        Route::get("search/{keyword}","ClientsController@search")->name("ajax.clients.search");
        Route::get("names","ClientsController@names")->name("ajax.clients.names");
    });

    //products
    Route::group(['prefix'=>'products','namespace'=>'Products','middleware'=>['permission:read product']],function (){
        Route::get("/","ProductsController@index")->name("ajax.products.index");
        Route::get("search","ProductsController@search")->name("ajax.products.search");
        Route::get("search/name","ProductsController@searchName")->name("ajax.products.search.name");
        Route::put("price/change/{product}","ProductsController@updatePrice")->name("ajax.products.price.update");

        Route::group(['prefix' => 'medicines'],function (){
            Route::get("/","MedicinesController@index")->name("ajax.products.medicines.index");
            Route::put("/purchases/","MedicinesController@purchases")->name("ajax.products.medicines.purchases");
            Route::put("/sell","MedicinesController@sell")->name("ajax.products.medicines.sell");
            Route::get("/search","MedicinesController@search")->name("ajax.products.medicines.search");
        });
        Route::group(['prefix' => 'graph'],function (){
            Route::get("location/{product}","ProductsController@locationsGraph")->name("ajax.products.graph.locations");
            Route::get("consumption/{product}","ProductsController@consumptionGraph")->name("ajax.products.graph.consumption");
            Route::get("prices/{product}","ProductsController@pricesGraph")->name("ajax.products.graph.prices");
            Route::get("income/statement/{product}","ProductsController@incomeStatementGraph")->name("ajax.products.graph.income.statement");
        });
        Route::group(['prefix' => 'selectors'],function (){
            Route::get("units","ProductsController@units")->name("ajax.products.units");
            Route::get("suppliers","ProductsController@suppliers")->name("ajax.products.suppliers");
            Route::get("categories","ProductsController@categories")->name("ajax.products.categories");
        });

    });

    //graph
    Route::group(['prefix' => 'graph'],function (){
        //chicks
        Route::group(['prefix' => 'chicks','namespace'=>'Chicks'],function (){
            Route::get("prices/{chick}","GraphController@prices")->name("ajax.graph.chicks.prices");
            Route::get("locations/{chick}","GraphController@locations")->name("ajax.graph.chicks.locations");
            Route::get("consumption/{chick}","GraphController@consumption")->name("ajax.graph.chicks.consumption");
        });

        Route::group(['prefix' => 'stocks','namespace'=>'Stocks'],function (){
            Route::get("Products/top/{stock}","GraphController@topProducts")->name("ajax.graph.stocks.top.products");
            Route::get("locations/{stock}","GraphController@locations")->name("ajax.graph.stocks.locations");
            Route::get("consumption/{stock}","GraphController@consumption")->name("ajax.graph.stocks.consumption");
        });


    });

    //category
    Route::group(['prefix' => 'categories','namespace'=>'Categories','middleware'=>['permission:read category']],function (){
        Route::get("/","CategoriesController@index")->name("ajax.categories.index");
    });

    //stocks
    Route::group(['prefix' => 'stocks','namespace' => 'Stocks','middleware'=>['permission:read stock']],function (){
        Route::get("/","StocksController@index")->name("ajax.stocks.index");
        Route::get("/list","StocksController@list")->name("ajax.stocks.list");
        Route::get("/names","StocksController@names")->name("ajax.stocks.names");

        Route::put("product/{pivot}/move","StocksController@move")->name("ajax.stocks.product.move");

        Route::group(['prefix'=>'charts'],function (){
            Route::get("consumption/{stock}","StocksController@consumptionGraph")->name("ajax.stocks.graph.consumption");
            Route::get("products/{stock}","StocksController@productsGraph")->name("ajax.stocks.graph.products");
            Route::get("location/{stock}","StocksController@locationsGraph")->name("ajax.stocks.graph.location");
        });

        Route::group(['prefix' => 'print'],function (){
            Route::get("stocktaking/{stock}","StocksController@stocktaking")->name("ajax.stocks.print.stocktaking");
        });
    });

    //users
    Route::group(['prefix' => 'users','namespace' => 'Users','middleware'=>['permission:read user']],function (){
        Route::get("/","UsersControllers@index")->name("ajax.users.index");
        Route::post("attendance/{user}","UsersControllers@attendance")->name("ajax.users.attendance");
        Route::put("departure/{user}","UsersControllers@departure")->name("ajax.users.departure");

        Route::put("/mark/notification/{notify}","UsersControllers@markNotification")->name("ajax.users.mark");
        Route::get("expired/notifications","UsersControllers@notifications")->name("ajax.users.expired.notifications");

        Route::group(['prefix'=>'balances'],function() {
            Route::get("client/{user}","UsersControllers@clientBalances")->name("ajax.users.balances.client");
            Route::get("supplier/{user}","UsersControllers@supplierBalances")->name("ajax.users.balances.supplier");
        });
    });
    //jobs
    Route::group(['prefix' => 'jobs', 'namespace'=>'Jobs', 'middleware' =>['permission:read job'] ],function (){
        Route::get("/","JobsController@index")->name("ajax.jobs.index");
    });

    //suppliers
    Route::group(['prefix' => 'suppliers','namespace' => "Suppliers",'middleware' => ['permission:read supplier|supplier_bill']],function (){
        Route::get("/","SuppliersController@index")->name("ajax.suppliers.index");
        Route::get("/balances/{supplier}","SuppliersController@balances")->name("ajax.suppliers.balances");

        //graph
        Route::group(['prefix'=>'graph'],function (){
            Route::get("quantity/{supplier}",'SuppliersController@quantityGraph')->name("ajax.suppliers.graph.quantity");
            Route::get("bills/{supplier}",'SuppliersController@billsGraph')->name("ajax.suppliers.graph.bills");
            Route::get("products/{supplier}",'SuppliersController@productsGraph')->name("ajax.suppliers.graph.products");
            Route::get("chicks/quantity/{supplier}",'SuppliersController@chicksQuantityGraph')->name("ajax.suppliers.graph.chicks.quantity");
            Route::get("chicks/{supplier}",'SuppliersController@chicksGraph')->name("ajax.suppliers.graph.chicks");
            Route::get("orders/{supplier}",'SuppliersController@ordersGraph')->name("ajax.suppliers.graph.orders");
            Route::get("income/statement/{supplier}",'SuppliersController@incomeStatementGraph')->name("ajax.suppliers.graph.income.statement");
        });
        //bills
        Route::group(['prefix' => 'bills','middleware' => ['permission:read supplier_bill']],function (){
            Route::get("/","BillsController@index")->name("ajax.suppliers.bills.index");
            Route::get("/balances/{bill}","BillsController@balances")->name("ajax.suppliers.bills.balances");
            Route::get("/products/{bill}","BillsController@products")->name("ajax.suppliers.bills.products");
            Route::get("returned/products/{bill}","BillsController@returnedProducts")->name("ajax.suppliers.bills.returned.products");
            Route::get("names/","BillsController@names")->name("ajax.suppliers.bills.names");
            Route::get("returned/codes","BillsController@codes")->name("ajax.suppliers.returned.bills.codes");
        });

        Route::group(['prefix' => 'print'],function (){

            Route::get("transaction/{bill}","BillsController@printTransaction")->name("ajax.suppliers.bills.print.transactions");
        });

    });

    //transactions
    Route::group(['namespace'=>'Transactions'],function (){
        Route::group(['prefix' => 'expenses'],function(){
            Route::get("/","ExpensesController@index")->name("ajax.transactions.expenses.index");
            Route::get("names","ExpensesController@names")->name("ajax.transactions.expenses.names");
        });
        Route::group(['prefix' => 'payments'],function(){
            Route::get("/","PaymentsController@index")->name("ajax.transactions.payments.index");
            Route::get("print/{payment}","PaymentsController@print")->name("ajax.transactions.payments.print");
            Route::group(['prefix' => 'purchases'],function (){
                Route::get("/","PaymentsController@purchases")->name("ajax.transactions.payments.purchases");

            });
            Route::group(['prefix' => 'returned'],function (){
                Route::get("/","PaymentsController@returned")->name("ajax.transactions.payments.returned");

            });
        });
        Route::group(['prefix' => 'receipts','namespace' => 'Receipts'],function(){
            Route::group(['prefix' => 'returned'],function (){
                Route::get("/","ReceiptsController@returned")->name("ajax.transactions.receipts.returned");
            });
            Route::get("/","ReceiptsController@purchases")->name("ajax.transactions.receipts.index");
            Route::get("print/{receipt}","ReceiptsController@print")->name("ajax.transactions.receipts.print");
        });
        Route::group(['prefix' => 'banks'],function(){
            Route::get("/","BanksController@index")->name("ajax.transactions.banks.index");
            Route::get("print/{bank?}","BanksController@print")->name("ajax.transactions.banks.print");
            Route::get("charts/{bank?}","BanksController@charts")->name("ajax.transactions.banks.charts");
            Route::get("names","BanksController@names")->name("ajax.transactions.banks.names");
        });
    });

    Route::group(['prefix' => 'dailies'],function (){
        Route::get("/","DailiesController@index")->name("ajax.dailies.index");
        Route::put("/close","DailiesController@close")->name("ajax.dailies.close");
        Route::get("/print/","DailiesController@print")->name("ajax.dailies.print");
        Route::get("/logout",function (){
            auth()->logout();
            return redirect()->route("login");
        })->name("ajax.dailies.logout");
    });

});
