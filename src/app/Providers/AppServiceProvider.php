<?php

namespace App\Providers;

use App\Services\BookService;
use App\Services\AuthorService;
use App\Handlers\BookTitleEditor;
use App\Handlers\AuthorNameEditor;
use Illuminate\Support\ServiceProvider;
use App\Handlers\BookAuthorNameEditor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('editable.author-name', AuthorNameEditor::class);
        $this->app->bind('editable.book-title', BookTitleEditor::class);
        $this->app->bind('editable.book-author-name', BookAuthorNameEditor::class);

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
