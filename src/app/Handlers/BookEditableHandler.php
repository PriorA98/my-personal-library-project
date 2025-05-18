<?php

namespace App\Handlers;

use App\Book;
use App\Contracts\EditableFieldHandler;
use Illuminate\Validation\ValidationException;

class BookEditableHandler implements EditableFieldHandler
{
    public function updateField(int $id, string $field, $value): void
    {
        if ($field !== 'title') {
            throw new \InvalidArgumentException("Field '{$field}' is not editable on books.");
        }

        $book = Book::findOrFail($id);

        if ($field === 'title') {
            if (Book::isDuplicateTitleForAuthor($book->author_id, $value, $id)) {
                throw ValidationException::withMessages([
                    'title' => 'The author "' . $book->author->name . '" already has a book with the title "' . $value . '".',
                ]);
            }
        }

        $book->$field = $value;
        $book->save();
    }
}
