<?php

namespace App\Domain\Tenants\Builder;

use App\Domain\Tenants\Dtos\TenantReportDto;
use Carbon\Carbon;

class  TenantReportBuilder
{
    private $tenant;
    private ?Carbon $startDate = null;
    private ?Carbon $endDate = null;
    public function __construct($tenant)
    {
        $this->tenant = $tenant;
    }
    public  function  forPeriod(Carbon $start, Carbon $end): self
    {
        $this->startDate = $start;
        $this->endDate = $end;
        return $this;
    }
  public function build(): TenantReportDto
{
    $contracts = $this->tenant->contracts() 
        ->with(['invoices.payments']) 
        ->where(function($query) {
            $query->whereBetween('start_date', [$this->startDate, $this->endDate])
                  ->orWhereBetween('end_date', [$this->startDate, $this->endDate]);
        })
        ->get();

    $invoices = $contracts->pluck('invoices')->flatten();
    $payments = $invoices->pluck('payments')->flatten();

    return new TenantReportDto(
        tenantName: $this->tenant->name,
        contracts: $contracts,
        invoices: $invoices,
        payments: $payments,

        totalBalance: $invoices->sum('total') - $payments->sum('amount')
    );
}
}
