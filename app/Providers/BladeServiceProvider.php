<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        Blade::directive("menu",function ($expression) {
            list($page,$class) = explode("," , $expression);
            return "<?php echo active_menu({$page},{$class}) ?>" ;
        });

        Blade::directive("homeMenu",function ($expression) {
            return "<?php echo active_menu_home({$expression}) ?>" ;
        });

        Blade::directive("menuAny",function ($expression){
            list($pages,$class) = explode("," , $expression);
            return "<?php echo active_menu_any({$pages},{$class}) ?>" ;
        });

    }
}
