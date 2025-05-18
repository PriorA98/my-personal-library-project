<?php

namespace App\Handlers;

use App\Book;
use App\Author;
use App\Services\AuthorService;
use App\Contracts\EditableFieldHandler;

class AuthorEditableHandler implements EditableFieldHandler
{
    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function updateField(int $id, string $field, $value): void
    {
        if ($field !== 'name') {
            throw new \InvalidArgumentException("Field '{$field}' is not editable on authors.");
        }

        $book = Book::where('author_id', $id)->firstOrFail();

        $existingAuthor = Author::where('name', $value)->first();

        if ($existingAuthor && $existingAuthor->id !== $id) {
            $book->author_id = $existingAuthor->id;
            $book->save();

            $this->authorService->deleteIfOrphaned($id);
        } else {
            $author = Author::findOrFail($id);
            $author->name = $value;
            $author->save();
        }
    }
}
