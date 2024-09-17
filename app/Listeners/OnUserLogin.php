<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Cache;

class OnUserLogin
{
    public function handle(Login $event): void
    {
        /** @var User $user */
        $user = $event->user;
        // Delete previous tokens
        $user->tokens()->delete();
        // Generate a new token
        $token = $user->createToken('brewery');
        Cache::set('token', $token->plainTextToken);
    }
}
