<?php
namespace App\Domain\Tax\Services;

use App\Domain\Tax\Interfaces\TaxCalculatorInterface;

class TaxService
{
    /** @var TaxCalculatorInterface[] */
    private array $calculators;

    public function __construct(array $calculators = [])
    {
        $this->calculators = $calculators;
    }

    public function calculateTax(float $amount): float
    {
        $totalTax = 0;

        foreach ($this->calculators as $calculator) {
            $totalTax += $calculator->calculate($amount);
        }

        return round($totalTax, 2);
    }
}