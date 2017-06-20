<?php

namespace App\Providers;

use App\Services\UrlShortener;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->singleton(UrlValidator::class,)
        $this->app->singleton(UrlShortener::class);
    }
}
