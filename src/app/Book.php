<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author_id'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public static function isDuplicateTitleForAuthor(int $authorId, string $title, int $excludeBookId = null): bool
    {
        $query = static::where('title', $title)
            ->where('author_id', $authorId);

        if ($excludeBookId) {
            $query->where('id', '!=', $excludeBookId);
        }

        return $query->exists();
    }
}
