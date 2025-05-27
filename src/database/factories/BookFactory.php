<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use App\Author;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(3),
        'author_id' => function () {
            return factory(Author::class)->create()->id;
        },
    ];
});
