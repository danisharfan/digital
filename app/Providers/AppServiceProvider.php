<?php

namespace App\Providers;

use App\Models\Pengaduan;
use App\Policies\PengaduanPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Pengaduan::class, PengaduanPolicy::class);

        Gate::define('admin-only', function ($user) {
            return $user->role === 'admin';
        });
    }
}
