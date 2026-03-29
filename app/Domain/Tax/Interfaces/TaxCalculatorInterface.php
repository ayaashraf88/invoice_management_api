<?php
namespace App\Domain\Tax\Interfaces;
interface TaxCalculatorInterface {
    public function calculate(float $amount, string $type): float;
}