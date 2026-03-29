<?php

namespace App\Domain\Payments\Repositories;

use App\Domain\Payments\Enums\PaymentMethodEnum;
use App\Domain\Payments\Models\Payment;

class EloquentPaymentRepository implements PaymentRepositoryInterface
{
    public function createPayment(array $data): Payment
    {
        return Payment::create($data);
    }
    public function getPaymentById(int $id): ?Payment
    {
        return Payment::find($id);
    }
    public function updatePaymentMethod(int $id, PaymentMethodEnum $method): ?Payment
    {
        $payment = Payment::find($id);
        if ($payment) {
            $payment->payment_method = $method;
            $payment->save();
        }
        return $payment;
    }
    public function deletePayment(int $id): bool
    {
        $payment = Payment::find($id);
        if ($payment) { 
            return $payment->delete();
        }
        return false;
    }
    public function getTotalPaidForInvoice(int $invoiceId): float
    {
        return (float) Payment::where('invoice_id', $invoiceId)
            ->sum('amount');
    }
    public function getTotalPaidForContract(int $contractId): float
    {
        return (float) Payment::whereHas('invoice', function ($query) use ($contractId) {
            $query->where('contract_id', $contractId);
        })->sum('amount');
    }
}
