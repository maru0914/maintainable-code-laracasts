<?php

namespace App\Providers;

use Mockery\Exception;
use App\Contracts\{WireRepositoryInterface, PayoneerRepositoryInterface, PaymentOption};
use App\Repositories\{WireRepository, PayoneerRepository};
use App\Services\PaymentOptions\{Wire, Payoneer, Wise};

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
        $this->app->bind(PaymentOption::class, function ($app) {
            if (request()->input('payment_type') == 'wire') {
                return $app->make(Wire::class);
            } elseif (request()->input('payment_type') == 'payoneer') {
                return $app->make(Payoneer::class);
            } elseif (request()->input('payment_type') == 'wise') {
                return $app->make(Wise::class);
            } else {
                throw new Exception('Invalid payment type.');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
