<?php

namespace App\Domain\Invoices\Repositories;

use App\Domain\Invoices\Enums\InvoiceStatusEnum;
use App\Domain\Invoices\Models\Invoice;
use Illuminate\Support\Facades\DB;

class EloquentInvoiceRepository implements InvoiceRepositoryInterface
{
    function createInvoice(array $data): Invoice
    {
        return Invoice::create($data);
    }
    function getInvoiceById(int $id): ?Invoice
    {
        return Invoice::withSum('payments', 'amount')
            ->with(['contract', 'payments'])
            ->find($id);
    }
    function updateInvoiceStatus(int $id, InvoiceStatusEnum $status): ?Invoice
    {
        $invoice = $this->getInvoiceById($id);
        if ($invoice) {
            $invoice->update(['status' => $status]);
        }
        return $invoice;
    }
    function deleteInvoice(int $id): bool
    {
        $invoice = $this->getInvoiceById($id);
        if ($invoice) {
            return $invoice->delete();
        }
        return false;
    }
    public function getNextSequence(int $tenantId): int
    {
        // return Invoice::whereHas('contract', function ($query) use ($tenantId) {
        //     $query->where('tenant_id', $tenantId);
        // })->count() + 1;
       return DB::transaction(function () use ($tenantId) {
            $sequence = Invoice::whereHas('contract', function ($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId);
            })->lockForUpdate()->count() + 1;
            return $sequence;
           });
    }
    function getTotalPaidForInvoice(int  $contractId): float
    {
        return (float) Invoice::where('contract_id', $contractId)
            ->sum('total_paid');
    }
    public function getTotalInvoicedForContract(int $contractId): float
    {
        return (float) Invoice::where('contract_id', $contractId)
            ->sum('total');
    }
    public function getInvoicesCount(int $contractId): float
    {
        return Invoice::where('contract_id', $contractId)->count();
    }
    public function getLatestInvoiceDate(int $contractId): ?string
    {
        $latestInvoice = Invoice::where('contract_id', $contractId)->latest('created_at')->first();
        return $latestInvoice ? $latestInvoice->created_at->format('Y-m-d') : null;
    }
    
}
