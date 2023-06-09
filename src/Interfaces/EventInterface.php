<?php

namespace App\Interfaces;

interface EventInterface
{
    public function searchByTermAndDate(string $term = null, string $date = null): array;

    public function importEventToDatabase(): string;
}