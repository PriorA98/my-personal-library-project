<?php

namespace App\Services;

use App\Author;

class AuthorService
{
    public function updateAuthorName($authorId, $newName)
    {
        $author = Author::findOrFail($authorId);
        $author->name = $newName;
        $author->save();

        return $author;
    }
}
