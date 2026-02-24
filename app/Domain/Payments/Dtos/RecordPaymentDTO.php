<?php
namespace App\Domain\Payments\Dtos;
use App\Domain\Payments\Enums\PaymentMethodEnum;
use Spatie\LaravelData\Data;
class RecordPaymentDTO  {
    public function __construct(
        public readonly int $invoice_id,
        public readonly float $amount,
        public readonly PaymentMethodEnum $payment_method,
        public readonly string $reference_number,
    ) {
    }
       public static function fromRequest(StorePaymentRequest $request): self
    {
        return new self(
            invoice_id: $request->validated('invoice_id'),
            amount: (float) $request->validated('amount'),
            payment_method: PaymentMethodEnum::from($request->validated('payment_method')),
            reference_number: $request->validated('reference_number'),
        );
    }
} 