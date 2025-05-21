<?php

namespace App\FieldEditors;

use App\Book;
use App\Author;
use App\Services\AuthorService;
use App\Contracts\FieldEditor;
use Illuminate\Validation\ValidationException;

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
        $currentTitle = $book->title;

        $existingAuthor = Author::where('name', $value)->first();

        $newAuthor = $existingAuthor ?: Author::create(['name' => $value]);

        if (Book::isDuplicateTitleForAuthor($newAuthor->id, $currentTitle, $book->id))
            throw ValidationException::withMessages([
                'author' => 'The author "' . $newAuthor->name . '" already has a book titled "' . $currentTitle . '".',
            ]);

        $book->author_id = $newAuthor->id;

        $book->save();

        $this->authorService->deleteIfOrphaned($oldAuthorId);
    }
}
