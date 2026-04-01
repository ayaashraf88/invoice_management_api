<?php
namespace App\Domain\Invoices\Facades;

use App\Domain\Invoices\Dtos\CreateInvoiceDTO;
use App\Domain\Invoices\Services\InvoiceService;
use App\Domain\Payments\Dtos\RecordPaymentDTO;
use Illuminate\Support\Facades\DB;
class InvoiceManagementFacade
{
    public function __construct(
        protected InvoiceService $invoiceService
    ) {}
    public function createInvoice(CreateInvoiceDTO $dto)
    {
        return DB::transaction(function () use ($dto) {
            return $this->invoiceService->createInvoice($dto);
        });
    }
    public function recordPayment(RecordPaymentDTO $dto)
    {
        return DB::transaction(function () use ($dto) {
            return $this->invoiceService->recordPayment($dto);
        });
    }
    public function getContractSummary($contractId)
    {
        return $this->invoiceService->getContractSummary($contractId);
    }

}