<?php

namespace App\Interfaces;

interface EventInterface
{
    public function searchByTermAndDate(string $term = null, string $date = null, int $page
    , int $perPage): array;

    public function importEventToDatabase(): string;
}