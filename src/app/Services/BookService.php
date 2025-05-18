<?php

namespace App\Services;

use App\Book;
use App\Author;
use Illuminate\Validation\ValidationException;

class BookService
{
    public function getAllBooksWithAuthors()
    {
        return Book::with('author')->get();
    }

    public function deleteBookById($id)
    {
        $book = Book::findOrFail($id);
        return $book->delete();
    }

    public function createBook(string $title, string $authorName)
    {
        $author = Author::firstOrCreate(['name' => $authorName]);

        $exists = Book::where('title', $title)
            ->where('author_id', $author->id)
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'title' => 'The author "' . $author->name . '" already has a book with the title "' . $title . '".',
            ]);
        }

        return Book::create([
            'title' => $title,
            'author_id' => $author->id,
        ]);
    }
}
