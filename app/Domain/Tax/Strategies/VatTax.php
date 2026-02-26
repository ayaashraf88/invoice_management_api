<?php
namespace App\Domain\Tax\Strategies;

use App\Domain\Tax\Interfaces\TaxCalculatorInterface;

class VatTax implements TaxCalculatorInterface{
    function calculate(float $amount): float
    {
        return $amount * 0.15;
    }
}