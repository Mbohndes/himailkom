<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use App\Models\ActivityLog;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Sensor Global: Akan terekam otomatis setiap ada yang berhasil Login
        Event::listen(function (Login $event) {
            ActivityLog::catat('Autentikasi', 'LOGIN', 'Pengguna berhasil login ke dalam sistem HIMA.');
        });
    }
}