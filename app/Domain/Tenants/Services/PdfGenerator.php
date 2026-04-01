<?php

namespace App\Domain\Tenants\Services;

use App\Domain\Tenants\Dtos\TenantReportDto;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfGenerator
{
    function generate(TenantReportDto $report): string
    {
        $pdf = Pdf::loadView('pdf.tenant-report', [
            'tenantName'   => $report->tenantName,
            'contracts'    => $report->contracts,
            'invoices'     => $report->invoices,
            'payments'     => $report->payments,
            'totalBalance' => $report->totalBalance,
        ]);
        return $pdf->output();
    }
}
