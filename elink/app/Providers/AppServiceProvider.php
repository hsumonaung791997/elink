<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Category;

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
       
        Schema::defaultStringLength(191);
        $categories = Category::all();
        $prices = DB::table('items')
                    ->orderBy('items.price','asc')
                    ->get();
        View::share('prices',$prices);
        View::share('categories',$categories);
    }
}
