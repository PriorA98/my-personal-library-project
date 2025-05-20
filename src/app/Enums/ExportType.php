<?php

namespace App\Enums;

class ExportType
{
    const TITLES_AND_AUTHORS = 'titles_authors';
    const TITLES = 'titles';
    const AUTHORS = 'authors';

    public static function all(): array
    {
        return [
            self::TITLES_AND_AUTHORS,
            self::TITLES,
            self::AUTHORS,
        ];
    }

    public static function isValid(string $value): bool
    {
        return in_array($value, self::all(), true);
    }
}
