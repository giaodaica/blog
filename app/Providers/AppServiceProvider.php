<?php

namespace App\Providers;

use App\Models\CategoriesVouchers;
use App\Models\Vouchers;
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
        View::composer('card.nav',function($view){
            $block = [1,2];
            $vouchers = [];
            foreach($block as $b){
                $voucher = Vouchers::where('block',$b)->
                where('status','active')->where('max_used','>=','1')->first();
                $vouchers[$b] = $voucher;
            }
            $view->with('vouchers',$vouchers);
        });
        Paginator::useBootstrapFive();
    }
}
