<?php

namespace App\Providers;

use App\Handlers\BookEditableHandler;
use App\Handlers\AuthorEditableHandler;
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
        $this->app->bind('editable.author', fn() => new AuthorEditableHandler());
        $this->app->bind('editable.book', fn() => new BookEditableHandler());
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
