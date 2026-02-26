<?php
namespace App\Domain\Tax\Strategies;
use App\Domain\Tax\Interfaces\TaxCalculatorInterface;
class MunicipalFee implements TaxCalculatorInterface{
    function calculate(float $amount): float
    {
        return $amount * 0.025;
    }
}      