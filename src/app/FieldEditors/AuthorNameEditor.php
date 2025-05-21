<?php

namespace App\FieldEditors;

use App\Book;
use App\Author;
use App\Services\AuthorService;
use App\Contracts\FieldEditor;
use Illuminate\Validation\ValidationException;

class AuthorNameEditor implements FieldEditor
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

        $books = Book::where('author_id', $id)->get();

        if ($books->isEmpty())
            throw new \RuntimeException("No books found for the given author ID.");


        $existingAuthor = Author::where('name', $value)->first();

        if ($existingAuthor && $existingAuthor->id !== $id) {
            foreach ($books as $book) {
                if (Book::isDuplicateTitleForAuthor($existingAuthor->id, $book->title, $book->id)) {
                    throw ValidationException::withMessages([
                        'name' => 'The author "' . $existingAuthor->name . '" already has a book titled "' . $book->title . '".',
                    ]);
                }
            }

            foreach ($books as $book) {
                $book->author_id = $existingAuthor->id;
                $book->save();
            }

            $this->authorService->deleteIfOrphaned($id);
        } else {
            $author = Author::findOrFail($id);
            $author->name = $value;
            $author->save();
        }
    }
}
