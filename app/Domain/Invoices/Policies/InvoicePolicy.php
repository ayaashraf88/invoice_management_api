<?php
namespace App\Domain\Invoices\Policies;

use App\Domain\Invoices\Models\Invoice;
use App\Domain\Users\Models\User;

class InvoicePolicy
{
    public function view(User $user, Invoice $invoice): bool
    {
        return $user->tenant_id === $invoice->Contract->tenant_id;
    }
}