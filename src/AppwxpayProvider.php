<?php

namespace Yuxiaoyang\Appwxpay;

use Illuminate\Support\ServiceProvider;

class AppwxpayProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('appwxpay',function(){
            return new Appwxpay();
        });//app('appwxpay')
    }
}
