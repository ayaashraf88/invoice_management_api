<?php

namespace App\Providers;

use App\Domain\Contracts\Models\Contract;
use App\Domain\Contracts\Policies\ContractPolicy;
use App\Domain\Invoices\Models\Invoice;
use App\Domain\Invoices\Policies\InvoicePolicy;
use App\Domain\Payments\Models\Payment;
use App\Domain\Payments\Policies\PaymentPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
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
     $this->app->singleton(\App\Domain\Tax\Services\TaxService::class, function ($app) {
        return new \App\Domain\Tax\Services\TaxService([
            new \App\Domain\Tax\Strategies\VatTax(),
            new \App\Domain\Tax\Strategies\MunicipalFee(),
        ]);
    });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Invoice::class, InvoicePolicy::class);
    }
}
