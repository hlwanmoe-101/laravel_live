<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewControlProvider extends ServiceProvider
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
        //view share
//        if(Schema::hasTable('categories')) {
//            View::share('categories', Category::all());
//        }
        View::share("my_name","hlwan moe aung");
    }
}
