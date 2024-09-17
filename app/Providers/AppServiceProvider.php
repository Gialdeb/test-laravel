<?php

namespace App\Providers;

use App\Listeners\OnUserLogin;
use App\Listeners\OnUserLogout;
use App\Repositories\BreweryApiRepository;
use App\Repositories\BreweryApiRepositoryInterface;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repository
        $this->app->bind(BreweryApiRepositoryInterface::class, BreweryApiRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::getAccessTokenFromRequestUsing(
            static function (Request $request) {
                return $request->string('token');
            }
        );
        Event::listen(
            Login::class,
            OnUserLogin::class,
        );
        Event::listen(
            Logout::class,
            OnUserLogout::class,
        );
    }
}
