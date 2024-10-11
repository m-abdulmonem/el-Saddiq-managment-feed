<?php

use App\Http\Controllers\Site\Attendances\AttendancesController;
use App\Http\Controllers\Site\Categories\CategoriesController;
use App\Http\Controllers\Site\Chicks\BookingController;
use App\Http\Controllers\Site\Chicks\ChicksController;
use App\Http\Controllers\Site\Chicks\OrdersController;
use App\Http\Controllers\Site\Clients\ClientsController;
use App\Http\Controllers\Site\Clients\InvoicesController;
use App\Http\Controllers\Site\DailiesController;
use App\Http\Controllers\Site\Dashboard\DashboardController;
use App\Http\Controllers\Site\Jobs\JobsController;
use App\Http\Controllers\Site\PDF\PDFController;
use App\Http\Controllers\Site\Products\HistoryController;
use App\Http\Controllers\Site\Products\MedicinesController;
use App\Http\Controllers\Site\Products\ProductsController;
use App\Http\Controllers\Site\SettingsController;
use App\Http\Controllers\Site\Stocks\StocksController;
use App\Http\Controllers\Site\Suppliers\BillsController;
use App\Http\Controllers\Site\Suppliers\SuppliersController;
use App\Http\Controllers\Site\Transactions\PayPurchasesController;
use App\Http\Controllers\Site\Transactions\Receive\SalesController;
use App\Http\Controllers\Site\Transactions\ReturnedController;
use App\Http\Controllers\Site\Users\ProfileController;
use App\Http\Controllers\Site\Users\SalariesController;
use App\Http\Controllers\Site\Users\UsersController;
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
Route::group(['middleware' => ['auth', 'language']], function () {


    //Dashboard
    Route::group(['namespace' => 'Dashboard', 'middleware' => ['checkSeller']], function () {
        Route::get("/", [DashboardController::class,'index'])->name("dashboard.index");
        Route::get("/language/{lang}", [DashboardController::class, 'lang'])->middleware("lang");
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

    Route::group([], function () {
        ///print/supplierBalance-{{ $bill->id  }}/supplier-Balance  -[example]

        Route::get("print/{id?}/{viewName?}", [PDFController::class,"index"])->name("print");
    }
    );

    //users
    Route::group(['middleware' => ['can:read user', 'checkSeller']], function () {

        //profile
        Route::group(['prefix' => 'profile'], function () {

            Route::put('password', [ProfileController::class,"password"])->name("profile.password.update");

            Route::resource("/", ProfileController::class)->except(['create', 'store', 'show']);
        }
        );

        //salaries
        Route::group([], function () {
            Route::resource("/salaries", SalariesController::class);
        }
        );

        //users
        Route::resource("users", UsersController::class);
    }
    );


    // categories
    Route::group(['middleware' => ['permission:read category', 'checkSeller']], function () {

        Route::resource("categories", CategoriesController::class)->except("create", "edit", "show");
    });

    //chicks
    Route::group(['middleware' => ['can:read chick']], function () {

        Route::group(['prefix' => 'chicks'], function () {

            Route::resource("orders", OrdersController::class, ["names" => "chicks.orders"])
                ->middleware(["can:read chick_order", 'checkSeller'])->except(['create', 'edit']);

            Route::resource("booking", BookingController::class, ["names" => "chicks.booking"])
                ->middleware(["can:read chick_booking"])->except(['create', 'edit']);
        }
        );

        Route::resource("chicks", ChicksController::class)->middleware(['permission:read chick'])->except(['create', 'edit']);
    }
    );

    //clients
    Route::group(['middleware' => ['can:read client']], function () {
        Route::group(['prefix' => 'clients'], function () {

            Route::group(['middleware' => ['permission:read client_bill']], function () {
                Route::resource("invoices", InvoicesController::class);
            });
        });

        Route::resource("clients", ClientsController::class);
    });

    //suppliers
    Route::group(['middleware' => ['permission:read supplier|supplier_bill', 'checkSeller']], function () {

        Route::group(['prefix' => 'suppliers', 'middleware' => ['permission:read supplier_bill']], function () {

            Route::resource("bills", BillsController::class);
        }
        );


        Route::resource("suppliers", SuppliersController::class); //        Route::get("bill/{supplier_id}","BillsController@all")
//            ->middleware("can:read supplier_bill")->name("bills.all");
    });


    //products
    Route::group(['middleware' => ['permission:read product|read medicine', 'checkSeller']], function () {

        //histories
        Route::group(['prefix' => 'products/history', 'middleware' => 'can:read product_history'], function () {
            Route::get("/", [HistoryController::class,"index"])->name("product.history");
            Route::get("prices", [HistoryController::class,"price"])->name("product.history.price");

        });

        Route::resource("products", ProductsController::class)->except("create", "edit");

        Route::resource("medicines", MedicinesController::class)->except("create", "edit", 'show')->middleware("can:read medicine");

        //using to get data from ajax request to suppliers bill
        Route::get("product/purchase/{supplier_id?}", [ProductsController::class,"ajxPurchaseIndex"])->middleware("can:read product")->name("product.all");

        Route::get("product/sell", [ProductsController::class,"ajaxSellIndex"])->middleware("can:read product")->name("product.sell");
        //    //to update price in product
        Route::put("product/{product_id}/price/update", [ProductsController::class,"price"])->middleware("can:update product")->name("product.price.update");

    }
    );

    //stocks
    Route::group(['middleware' => ['can:read stock', 'checkSeller']], function () {

        Route::resource("stocks", stocksController::class)->names('stocks');
    });


    //attendances
    Route::group(['prefix' => 'attendances',  'middleware' => ['can:read attendance', 'checkSeller']], function () {
        Route::get("/", [AttendancesController::class,"index"])->name('attendances.index');
        Route::get("events", [AttendancesController::class,"events"])->name("ajax.attendances.events");
    }
    );

    //jobs
    Route::group(['middleware' => ['can:read job', 'checkSeller']], function () {
        Route::resource("jobs", JobsController::class)->except('create', 'show', 'edit');
    }
    );


    Route::group(['middleware' => ['checkSeller']], function () {
        //payments
        Route::group([], function () {
            Route::apiResources([
                "expenses" => ExpensesController::class,
                "banks" => BanksController::class,
                "payments" => PaymentsController::class,
            ], ['only' => ['index', 'store', 'update', 'destroy']]);

            // Route::apiResource("expenses", "ExpensesController"); //->except('create','show','edit');
            // Route::apiResource(); //->except('create','show','edit');
            // Route::apiResource(); //->except('create','show','edit');

            Route::group(['prefix' => 'payment'], function () {
                Route::apiResource("purchases", PayPurchasesController::class); //->only('index','store','update');
                Route::apiResource("returned", ReturnedController::class); //->only('index','store','update');
            }
            );
        }
        );
        Route::group([], function () {
            Route::resource("receipts/sales", SalesController::class)->only("index", 'store', 'update');
            Route::resource("receipts/returned", ReturnedController::class)->names("purchases.returned")->only("index", 'store', 'update');
        }
        );
    }
    );

    Route::group(['middleware' => ['checkSeller']], function () {
        Route::resource("dailies", DailiesController::class)->only("index", 'store', 'update');
    }
    );


    /*
 * Settings
 */
    Route::group(['prefix' => 'settings'], function () {
        Route::get("/", [SettingsController::class,"index"])->name("settings.index")->middleware(["permission:read setting"]);
        Route::put("main-info", [SettingsController::class,"main_info"])->name("settings.update")->middleware(["permission:update setting"]);
        Route::put("mobile-apps", [SettingsController::class,"apps_save"])->middleware(["role:super-admin|admin", "permission:	edit mobile app links"]);
        Route::put("social-media", [SettingsController::class,"social_media"])->middleware(["role:super-admin|admin", "permission:edit social links"]);
        Route::put("maintenance", [SettingsController::class,"maintenance"])->middleware(["role:super-admin|admin", 'permission:edit site maintenance']);

    }
    );

});

Route::get("daily", DailliesControler::class)->name("dailies.daily");

Auth::routes();

Route::view("frontend", "frontend.pages.home");
