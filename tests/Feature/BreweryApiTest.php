<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class BreweryApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // Seed database with default user
        $this->artisan('db:seed');
    }

    /**
     * @test
     */
    public function guest_user_cannot_use_brewery_api(): void
    {
        $response = $this->getJson(route('api.breweries.index'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function authenticated_user_can_use_brewery_api(): void
    {
        $user = User::firstOrFail();
        $response = $this->actingAs($user)->getJson(route('api.breweries.index'));

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function brewery_api_pagination_is_working(): void
    {
        $user = User::firstOrFail();
        $firstPageResponse = $this->actingAs($user)->getJson(route('api.breweries.index', ['page' => 1, 'limit' => 20]));

        $firstPageResponse->assertJsonCount(20);

        $secondPageResponse = $this->actingAs($user)->getJson(route('api.breweries.index', ['page' => 2, 'limit' => 20]));
        $secondPageResponse->assertJsonCount(20);

        $firstElement = $firstPageResponse->json()[0]['id'];
        $secondElement = $secondPageResponse->json()[0]['id'];

        $this->assertNotSame($firstElement, $secondElement);
    }

    /**
     * @test
     */
    public function api_will_return_error_on_external_service_down(): void
    {
        $user = User::firstOrFail();

        Http::shouldReceive('get')->andThrow(new NotFoundHttpException('Not found'));

        $response = $this->actingAs($user)->getJson(route('api.breweries.index'));

        $response->assertStatus(Response::HTTP_SERVICE_UNAVAILABLE);

        $response->assertJsonStructure([
            'error',
        ]);

        $response->assertJson(['error' => 'Not found']);
    }

    /**
     * @test
     */
    public function user_with_token_can_use_brewery_api(): void
    {
        $user = User::firstOrFail();
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $token = Cache::get('token');
        $this->assertNotNull($token);
        $this->post('/logout');
        $this->assertGuest();

        $response = $this->get(route('breweries.index', ['token' => $token]));

        $response->assertStatus(Response::HTTP_OK);
    }
}
