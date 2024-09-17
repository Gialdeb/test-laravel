<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class LoginTokenTest extends TestCase
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
    public function token_is_generated_on_login(): void
    {
        $user = User::firstOrFail();
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $this->assertNotNull(Cache::get('token'));
    }

    /**
     * @test
     */
    public function token_is_destroyed_on_logout(): void
    {
        $user = User::firstOrFail();
        $this->actingAs($user)->post('/logout');

        $this->assertGuest();

        $this->assertNull(Cache::get('token'));
    }
}
