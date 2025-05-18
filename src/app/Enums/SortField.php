<?php

namespace App\Enums;

class SortField
{
    const TITLE = 'title';
    const AUTHOR = 'author';

    public static function all(): array
    {
        return [self::TITLE, self::AUTHOR];
    }
}
