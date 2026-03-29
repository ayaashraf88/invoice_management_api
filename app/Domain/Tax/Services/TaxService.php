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

    public function calculateTax(float $amount, string $type): float
    {
        $totalTax = 0;

        // foreach ($this->calculators as $calculator) {
        //     $totalTax += $calculator->calculate($amount, $type);
        // }

        // return round($totalTax, 2);
        if(!isset($this->calculators[$type])){
            throw new \Exception("No tax calculator found for type: $type");
        }
        return round($this->calculators[$type]->calculate($amount, $type), 2);
    }
}