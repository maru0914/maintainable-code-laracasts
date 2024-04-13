<?php

namespace App\Providers;

use App\Contracts\PayoneerRepositoryInterface;
use App\Contracts\WireRepositoryInterface;
use App\Repositories\PayoneerRepository;
use App\Repositories\WireRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WireRepositoryInterface::class, WireRepository::class);
        $this->app->bind(PayoneerRepositoryInterface::class, PayoneerRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
