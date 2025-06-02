<?php

namespace App\Providers;

use App\Models\CategoriesVouchers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        View::composer('dashboard.card.menu',function($view){
            $menu_voucher = CategoriesVouchers::all();
            $view->with('menu',$menu_voucher);
        });
        Paginator::useBootstrapFive();
    }
}
