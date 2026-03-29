<?php
namespace App\Domain\Tax\Strategies;
use App\Domain\Tax\Interfaces\TaxCalculatorInterface;
class MunicipalFee implements TaxCalculatorInterface{
    function calculate(float $amount, string $type): float
    {
        if ($type === 'municipal') {
            return $amount * 0.025;
        }
        throw new \InvalidArgumentException('Unsupported tax type');
    }
}      