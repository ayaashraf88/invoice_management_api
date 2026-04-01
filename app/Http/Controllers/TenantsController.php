<?php

namespace App\Http\Controllers;

use App\Domain\Tenants\Builder\TenantReportBuilder;
use App\Domain\Tenants\Models\Tenant;
use App\Domain\Tenants\Services\PdfGenerator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TenantsController extends Controller
{
    use AuthorizesRequests;

    function download(Tenant $tenant, PdfGenerator $generator): string
    {
        $this->authorize('viewReport', $tenant);
        $report = new  TenantReportBuilder($tenant)->forPeriod(now()->subMonth(), now())->build();
        $content = $generator->generate($report);
       return response($content)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'attachment; filename="report-' . $tenant->id . '.pdf"')
        ->header('Cache-Control', 'no-cache, private');
    }
}
