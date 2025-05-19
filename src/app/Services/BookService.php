<?php

namespace App\Services;

use App\Book;
use App\Author;
use Illuminate\Validation\ValidationException;

class BookService
{

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

    public function getBooksWithAuthorsFilteredAndSorted($search = '', $sortField = 'title', $sortDirection = 'asc')
    {
        $query = Book::with('author');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhereHas('author', function ($sub) use ($search) {
                        $sub->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($sortField === 'author') {
            $query->join('authors', 'books.author_id', '=', 'authors.id')
                ->orderBy('authors.name', $sortDirection)
                ->select('books.*');
        } else {
            $query->orderBy($sortField, $sortDirection);
        }

        return $query->get();
    }

}
