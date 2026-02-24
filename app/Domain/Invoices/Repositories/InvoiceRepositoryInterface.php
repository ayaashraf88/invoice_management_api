<?php
namespace App\Domain\Invoices\Repositories;
use App\Domain\Invoices\Enums\InvoiceStatusEnum;
use App\Domain\Invoices\Models\Invoice;
interface InvoiceRepositoryInterface {
    public function createInvoice(array $data): Invoice;
    public function getInvoiceById(int $id): ?Invoice;
    public function updateInvoiceStatus(int $id, InvoiceStatusEnum $status): ?Invoice;
    public function deleteInvoice(int $id): bool;
}
