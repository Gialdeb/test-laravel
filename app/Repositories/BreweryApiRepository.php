<?php

namespace App\Repositories;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class BreweryApiRepository implements BreweryApiRepositoryInterface
{
    public function beers(?int $page = 0, ?int $perPage = 20): JsonResponse
    {
        try {
            $response = Http::get(sprintf('%s?page=%u&per_page=%u', config('api.endpoint'), $page, $perPage));
            $response->throw();

            return response()->json($response->json());
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
}
