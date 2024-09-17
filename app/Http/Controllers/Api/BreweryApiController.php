<?php

namespace App\Http\Controllers\Api;

use App\Repositories\BreweryApiRepositoryInterface;
use Illuminate\Http\JsonResponse;

class BreweryApiController
{
    public function __construct(private readonly BreweryApiRepositoryInterface $repository) {}

    public function index(?int $page = 0, ?int $limit = 20): JsonResponse
    {
        return $this->repository->beers($page, $limit);
    }
}
