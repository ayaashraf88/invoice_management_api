<?php
namespace App\Domain\Tenants\Dtos;

use Illuminate\Support\Collection;

readonly class TenantReportDto
{
    public function __construct(
        public string $tenantName,
        public Collection $contracts,
        public Collection $invoices, 
        public Collection $payments,
        public float $totalBalance
    ) {}
}