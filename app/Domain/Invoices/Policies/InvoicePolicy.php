<?php

namespace App\Domain\Invoices\Policies;

use App\Domain\Contracts\Models\Contract;
use App\Domain\Invoices\Models\Invoice;
use App\Domain\Users\Models\User;

class InvoicePolicy
{
    public function view(User $user, Invoice $invoice): bool
    {
        return $user->tenant_id === $invoice->Contract->tenant_id;
    }
    public function  create(User $user, Contract $contract)
    {
        return $user->tenant_id === $contract->tenant_id;
    }
    public function recordPayment(User $user, Invoice $invoice): bool
    {
        $isSameTenant = $user->tenant_id === $invoice->Contract->tenant_id;
        $isNotCancelled = $invoice->status !== 'cancelled';
        return $isSameTenant && $isNotCancelled;
    }
}
