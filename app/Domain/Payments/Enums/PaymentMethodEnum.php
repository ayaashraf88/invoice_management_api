<?php
namespace App\Domain\Payments\Enums;

enum PaymentMethodEnum: string {
    case CASH = 'cash';
    case CREDIT_CARD = 'credit_card';
    case BANK_TRANSFER = 'bank_transfer';
}
