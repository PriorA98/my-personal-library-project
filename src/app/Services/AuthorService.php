<?php

namespace App\Services;

use App\Author;
use App\Book;

class AuthorService
{
    public function deleteIfOrphaned(int $authorId): void
    {
        $bookCount = Book::where('author_id', $authorId)->count();

        if ($bookCount === 0) {
            Author::where('id', $authorId)->delete();
        }
    }
}