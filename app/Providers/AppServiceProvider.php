<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Chick\BookingChick;
use App\Models\Chick\Chick;
use App\Models\Chick\ChickOrder;
use App\Models\Client\Client;
use App\Models\Client\ClientBillReturn;
use App\Models\Product\Product;
use App\Models\Supplier\SupplierBill;
use App\Models\Supplier\SupplierBillReturn;
use App\Models\User;
use App\Observers\Category\CategoryObserver;
use App\Observers\Chicks\BookingObserver;
use App\Observers\Chicks\ChickOrderObserver;
use App\Observers\Clients\ClientsObservers;
use App\Observers\Clients\InvoicesObservers;
use App\Observers\Supplier\ReturnedBillObServers;
use App\Observers\Clients\ReturnedInvoicesObServers;
use App\Observers\Product\ProductObserver;
use App\Observers\Supplier\BillsObserver;
use App\Observers\Supplier\SupplierObserver;
use App\Observers\User\UserObserver;
use App\Services\Chicks\bookingServices;
use App\Services\Clients\bills\InvoicesServices;
use App\Services\Clients\ClientsServices;
use App\Services\Products\ProductServices;
use App\Services\Supplier\Bills\BillServices;
use App\Services\Supplier\SupplierServices;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        ChickOrder::observe(ChickOrderObserver::class);

        bookingServices::observe(BookingObserver::class);

        BillServices::observe(BillsObserver::class);

        Category::observe(CategoryObserver::class);

        SupplierServices::observe(SupplierObserver::class);
        SupplierBillReturn::observe(ReturnedBillObServers::class);

        InvoicesServices::observe(InvoicesObservers::class);
        ClientBillReturn::observe(ReturnedInvoicesObServers::class);

        User::observe(UserObserver::class);
        ProductServices::observe(ProductObserver::class);
        ClientsServices::observe(ClientsObservers::class);

    }
}
