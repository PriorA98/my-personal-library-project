<?php

namespace App\Contracts;

interface EditableFieldHandler
{
    public function updateField(int $id, string $field, $value): void;
}
