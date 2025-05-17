<?php

namespace App\Providers;
use App\Services\BookService;
use App\Services\AuthorService;

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
        $this->app->singleton(BookService::class, function ($app) {
            return new BookService();
        });

        $this->app->singleton(AuthorService::class, function ($app) {
            return new AuthorService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
