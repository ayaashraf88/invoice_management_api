<?php
namespace App\Domain\Tax\Strategies;

use App\Domain\Tax\Interfaces\TaxCalculatorInterface;

class VatTax implements TaxCalculatorInterface{
    function calculate(float $amount, string $type): float
    {
        if ($type === 'vat') {
            return $amount * 0.15;
        }
        throw new \InvalidArgumentException('Unsupported tax type');
    }
}