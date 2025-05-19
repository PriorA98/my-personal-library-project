<?php

namespace App\Handlers;

use App\Book;
use App\Author;
use App\Services\AuthorService;
use App\Contracts\FieldEditor;

class BookAuthorNameEditor implements FieldEditor
{
    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function updateField(int $bookId, string $field, $value): void
    {
        if ($field !== 'author') {
            throw new \InvalidArgumentException("Field '{$field}' is not editable on authors.");
        }

        $book = Book::findOrFail($bookId);
        $oldAuthorId = $book->author_id;

        $existingAuthor = Author::where('name', $value)->first();

        if ($existingAuthor) {
            $book->author_id = $existingAuthor->id;
        } else {
            $book->author_id = Author::create(['name' => $value])->id;
        }

        $book->save();

        $this->authorService->deleteIfOrphaned($oldAuthorId);
    }
}
