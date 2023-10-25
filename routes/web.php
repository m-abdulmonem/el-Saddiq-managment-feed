<?php

use Inertia\Inertia;
use App\Models\Client\Client;
use App\Models\Dailies\Daily;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Site\Transactions\BanksController;
use App\Http\Controllers\Dashboard\Daillies\DailliesControler;
use App\Http\Controllers\Site\Transactions\ExpensesController;
use App\Http\Controllers\Site\Transactions\PaymentsController;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! | */

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});
//
//Route::get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');


/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! | */
Route::group(['middleware' => ['auth', 'language'], 'namespace' => 'Site'], function () {


    //Dashboard
    Route::group(['namespace' => 'Dashboard', 'middleware' => ['checkSeller']], function () {
            Route::get("/", "DashboardController@index")->name("dashboard.index");
            Route::get("/language/{lang}", 'DashboardController@lang')->middleware("lang");
            Route::get("/sms", function () {
                    // Find your Account Sid and Auth Token at twilio.com/console
// and set the environment variables. See http://twil.io/secure
                    $sid = getenv("TWILIO_ACCOUNT_SID");
                    $token = getenv("TWILIO_AUTH_TOKEN");
                    $twilio = new Client("ACc33f9ea52b880a8df0d833d7e527065f", "edeff2f9e6792e2721687a7f0605674f");

                    $message = $twilio->messages->create("00201099647084", ["body" => "Hi there!", "from" => "el-saddiq"]);


                    dd($message);

                }
                );

            }
            );

            Route::group(['namespace' => 'PDF'], function () {
            ///print/supplierBalance-{{ $bill->id  }}/supplier-Balance  -[example]

            Route::get("print/{id?}/{viewName?}", "PDFController@index")->name("print");
        }
        );

        //users
        Route::group(['middleware' => ['can:read user', 'checkSeller'], 'namespace' => 'Users'], function () {

            //profile
            Route::group(['prefix' => 'profile'], function () {

                    Route::put('password', "ProfileController@password")->name("profile.password.update");

                    Route::resource("/", "ProfileController")->except(['create', 'store', 'show']);
                }
                );

                //salaries
                Route::group([], function () {
                    Route::resource("/salaries", 'SalariesController');
                }
                );

                //users
                Route::resource("users", "UsersController");
            }
            );


            // categories
            Route::group(['middleware' => ['permission:read category', 'checkSeller'], 'namespace' => 'Categories'], function () {

            Route::resource("categories", "CategoriesController")->except("create", "edit", "show");
        }
        );

        //chicks
        Route::group(['middleware' => ['can:read chick'], 'namespace' => 'Chicks'], function () {

            Route::group(['prefix' => 'chicks'], function () {

                    Route::resource("orders", "OrdersController", ["names" => "chicks.orders"])
                        ->middleware(["can:read chick_order", 'checkSeller'])->except(['create', 'edit']);

                    Route::resource("booking", "BookingController", ["names" => "chicks.booking"])
                        ->middleware(["can:read chick_booking"])->except(['create', 'edit']);
                }
                );

                Route::resource("chicks", "ChicksController")->middleware(['permission:read chick'])->except(['create', 'edit']);
            }
            );

            //clients
            Route::group(['middleware' => ['can:read client'], 'namespace' => 'Clients'], function () {
            Route::group(['prefix' => 'clients'], function () {

                    Route::group(['middleware' => ['permission:read client_bill']], function () {
                            Route::resource("invoices", "InvoicesController");
                        }
                        );
                    }
                    );

                    Route::resource("clients", "ClientsController");
                }
                );

                //suppliers
                Route::group(['middleware' => ['permission:read supplier|supplier_bill', 'checkSeller'], 'namespace' => 'Suppliers'], function () {

            Route::group(['prefix' => 'suppliers', 'middleware' => ['permission:read supplier_bill']], function () {

                    Route::resource("bills", "BillsController");
                }
                );


                Route::resource("suppliers", "SuppliersController"); //        Route::get("bill/{supplier_id}","BillsController@all")
//            ->middleware("can:read supplier_bill")->name("bills.all");
            }
            );


            //products
            Route::group(['middleware' => ['permission:read product|read medicine', 'checkSeller'], 'namespace' => 'Products'], function () {

            //histories
            Route::group(['prefix' => 'products/history', 'middleware' => 'can:read product_history'], function () {
                    Route::get("/", "HistoryController@index")->name("product.history");
                    Route::get("prices", "HistoryController@price")->name("product.history.price");

                }
                );

                Route::resource("products", "ProductsController")->except("create", "edit");

                Route::resource("medicines", "MedicinesController")->except("create", "edit", 'show')->middleware("can:read medicine");

                //using to get data from ajax request to suppliers bill
                Route::get("product/purchase/{supplier_id?}", "ProductsController@ajxPurchaseIndex")->middleware("can:read product")->name("product.all");

                Route::get("product/sell", "ProductsController@ajaxSellIndex")->middleware("can:read product")->name("product.sell");
                //    //to update price in product
                Route::put("product/{product_id}/price/update", "ProductsController@price")->middleware("can:update product")->name("product.price.update");

            }
            );

            //stocks
            Route::group(['middleware' => ['can:read stock', 'checkSeller'], 'namespace' => 'Stocks'], function () {

            Route::resource("stocks", "stocksController")->names('stocks');
        }
        );


        //attendances
        Route::group(['prefix' => 'attendances', 'namespace' => 'Attendances', 'middleware' => ['can:read attendance', 'checkSeller']], function () {
            Route::get("/", "AttendancesController@index")->name('attendances.index');
            Route::get("events", "AttendancesController@events")->name("ajax.attendances.events");
        }
        );

        //jobs
        Route::group(['namespace' => 'Jobs', 'middleware' => ['can:read job', 'checkSeller']], function () {
            Route::resource("jobs", "JobsController")->except('create', 'show', 'edit');
        }
        );


        Route::group(['namespace' => 'Transactions', 'middleware' => ['checkSeller']], function () {
            //payments
            Route::group([], function () {
                    Route::apiResources([
                        "expenses" => ExpensesController::class ,
                        "banks" => BanksController::class ,
                        "payments" => PaymentsController::class ,
                    ], ['only' => ['index', 'store', 'update', 'destroy']]);

                    // Route::apiResource("expenses", "ExpensesController"); //->except('create','show','edit');
                    // Route::apiResource(); //->except('create','show','edit');
                    // Route::apiResource(); //->except('create','show','edit');

                    Route::group(['prefix' => 'payment'], function () {
                            Route::apiResource("purchases", "PayPurchasesController"); //->only('index','store','update');
                            Route::apiResource("returned", "ReturnedController"); //->only('index','store','update');
                        }
                        );
                    }
                    );
                    Route::group(['namespace' => 'Receive'], function () {
                    Route::resource("receipts/sales", "SalesController")->only("index", 'store', 'update');
                    Route::resource("receipts/returned", "ReturnedController")->names("purchases.returned")->only("index", 'store', 'update');
                }
                );
            }
            );

            Route::group(['middleware' => ['checkSeller']], function () {
            Route::resource("dailies", "DailiesController")->only("index", 'store', 'update');
        }
        );


        /*
     * Settings
     */
        Route::group(['prefix' => 'settings'], function () {
            Route::get("/", "SettingsController@index")->name("settings.index")->middleware(["permission:read setting"]);
            Route::put("main-info", "SettingsController@main_info")->name("settings.update")->middleware(["permission:update setting"]);
            Route::put("mobile-apps", "SettingsController@apps_save")->middleware(["role:super-admin|admin", "permission:	edit mobile app links"]);
            Route::put("social-media", "SettingsController@social_media")->middleware(["role:super-admin|admin", "permission:edit social links"]);
            Route::put("maintenance", "SettingsController@maintenance")->middleware(["role:super-admin|admin", 'permission:edit site maintenance']);

        }
        );

    });

Route::get("daily", DailliesControler::class)->name("dailies.daily");

Auth::routes();

Route::view("frontend", "frontend.pages.home");
