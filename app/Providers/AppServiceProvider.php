<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Contracts\Repositories\ContractRepositoryInterface::class,
            \App\Domain\Contracts\Repositories\EloquentContractRepository::class
        );
        $this->app->bind(
            \App\Domain\Invoices\Repositories\InvoiceRepositoryInterface::class,
            \App\Domain\Invoices\Repositories\EloquentInvoiceRepository::class
        );
        $this->app->bind(
            \App\Domain\Payments\Repositories\PaymentRepositoryInterface::class,
            \App\Domain\Payments\Repositories\EloquentPaymentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
