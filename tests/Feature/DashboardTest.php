<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DashboardTest extends TestCase
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
    public function guest_user_cannot_access_dashboard(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function authenticated_user_can_access_dashboard(): void
    {
        $user = User::firstOrFail();
        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(Response::HTTP_OK);
    }
}
