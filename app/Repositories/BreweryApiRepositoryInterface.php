<?php

namespace App\Repositories;

use Illuminate\Http\JsonResponse;

interface BreweryApiRepositoryInterface
{
    public function beers(?int $page = 0, ?int $perPage = 20): JsonResponse;
}
