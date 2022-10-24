<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Blade;
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

        Blade::directive('hma',function (){
            return "HMA";
        });//@hma

        Blade::if('onlyAdmin',function (){
           return
               auth()->user()->role=="admin";
        });


        View::share("my_name","hlwan moe aung");

        View::composer(['home','category'],function (){
            View::share('cat',Category::all());
        });
    }
}
