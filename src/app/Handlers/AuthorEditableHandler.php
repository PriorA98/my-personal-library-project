<?php

namespace App\Handlers;

use App\Author;
use App\Contracts\EditableFieldHandler;

class AuthorEditableHandler implements EditableFieldHandler
{
    public function updateField(int $id, string $field, $value): void
    {
        $author = Author::findOrFail($id);
        $author->$field = $value;
        $author->save();
    }
}
