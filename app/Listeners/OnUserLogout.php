<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Cache;

class OnUserLogout
{
    public function handle(Logout $event): void
    {
        Cache::forget('token');
    }
}
