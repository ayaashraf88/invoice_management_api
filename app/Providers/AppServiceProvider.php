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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Contract::class, ContractPolicy::class);
        Gate::policy(Invoice::class, InvoicePolicy::class);
        Gate::policy(Payment::class, PaymentPolicy::class);
    }
}
