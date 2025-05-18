<?php

namespace App\Providers;

use App\Services\BookService;
use App\Services\AuthorService;
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
        $this->app->bind('editable.author', AuthorEditableHandler::class);
        $this->app->bind('editable.book', BookEditableHandler::class);

        $this->app->singleton(BookService::class, fn() => new BookService());
        $this->app->singleton(AuthorService::class, fn() => new AuthorService());
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
