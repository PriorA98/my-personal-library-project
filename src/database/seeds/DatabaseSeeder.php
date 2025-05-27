<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Author::class, 5)->create()->each(function ($author) {
            factory(App\Book::class, 3)->create(['author_id' => $author->id]);
        });
    }
}
