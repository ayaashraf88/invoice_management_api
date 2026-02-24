<?php
namespace App\Domain\Payments\Repositories;
use App\Domain\Payments\Enums\PaymentMethodEnum;
use App\Domain\Payments\Models\Payment;
interface PaymentRepositoryInterface {
    public function createPayment(array $data): Payment;
    public function getPaymentById(int $id): ?Payment;
    public function updatePaymentMethod(int $id, PaymentMethodEnum $method): ?Payment;
    public function deletePayment(int $id): bool;
}
