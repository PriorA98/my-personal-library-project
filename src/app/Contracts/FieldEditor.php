<?php

namespace App\Contracts;

interface FieldEditor
{
    public function updateField(int $id, string $field, $value): void;
}
