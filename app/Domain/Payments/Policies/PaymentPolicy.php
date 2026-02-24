<?php
namespace App\Domain\Payments\Policies;

use App\Domain\Payments\Models\Payment;
use App\Domain\Users\Models\User;

class PaymentPolicy
{
    public function view(User $user, Payment $payment): bool
    {
        return $user->tenant_id === $payment->Invoice->tenant_id;
    }

}