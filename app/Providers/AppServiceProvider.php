<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Gate::define('admin', fn (User $user): bool => $user->is_admin);
        RateLimiter::for('login', fn (Request $request): array => [
            Limit::perMinute(20)->by('login-ip:'.$request->ip()),
            Limit::perMinute(5)->by('login-account:'.hash('sha256', strtolower(is_string($request->input('email')) ? trim($request->input('email')) : ''))),
        ]);
        RateLimiter::for('api', fn (Request $request): Limit => Limit::perMinute(120)->by($request->ip()));
    }
}
