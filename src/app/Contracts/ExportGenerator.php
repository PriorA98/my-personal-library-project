<?php

namespace App\Contracts;

interface ExportGenerator
{
    public function toCsv(): string;
    public function toXml(): string;
}
