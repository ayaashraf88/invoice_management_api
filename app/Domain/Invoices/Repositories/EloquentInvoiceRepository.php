<?php

namespace App\Domain\Invoices\Repositories;

use App\Domain\Invoices\Enums\InvoiceStatusEnum;
use App\Domain\Invoices\Models\Invoice;

class EloquentInvoiceRepository implements InvoiceRepositoryInterface
{
    function createInvoice(array $data): Invoice
    {
        return Invoice::create($data);
    }
    function getInvoiceById(int $id): ?Invoice
    {
        return Invoice::find($id);
    }
    function updateInvoiceStatus(int $id, InvoiceStatusEnum $status): ?Invoice
    {
        $invoice = $this->getInvoiceById($id);
        if ($invoice) {
            $invoice->update(['status' => $status]);
        }
        return $invoice;
    }
    function deleteInvoice(int $id): bool {
        $invoice = $this->getInvoiceById($id);
        if ($invoice) {
            return $invoice->delete();
        }
        return false;
    }
}
