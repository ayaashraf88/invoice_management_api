<?php

namespace App\Domain\Invoices\Services;

use App\Domain\Invoices\Dtos\CreateInvoiceDTO;
use App\Domain\Contracts\Repositories\ContractRepositoryInterface;
use App\Domain\Invoices\Enums\InvoiceStatusEnum;
use App\Domain\Invoices\Models\Invoice;
use App\Domain\Invoices\Repositories\InvoiceRepositoryInterface;
use App\Domain\Payments\Dtos\RecordPaymentDTO;
use App\Domain\Payments\Models\Payment;
use App\Domain\Payments\Repositories\PaymentRepositoryInterface;
use App\Domain\Tax\Services\TaxService;
use Illuminate\Support\Facades\DB;
class InvoiceService
{
    public function __construct(
        private ContractRepositoryInterface $contractRepo,
        private InvoiceRepositoryInterface $invoiceRepo,
        private PaymentRepositoryInterface $paymentRepo,
        private TaxService $taxService,
    ) {}
    public function createInvoice(CreateInvoiceDTO $dto): Invoice
    {
        $contract = $this->contractRepo->getContractById($dto->contract_id);
        if (!$contract) {
            throw new \Exception('Contract not found');
        }

        $subtotal = $contract->rent_amount;
        $taxAmount = $this->taxService->calculateTax($subtotal,'municipal                                      ');
        $total = $subtotal + $taxAmount;
        return $this->invoiceRepo->createInvoice([
            'contract_id' => $dto->contract_id,
            'invoice_number' => $this->generateInvoiceNumber($dto->tenant_id),
            'due_date' => $dto->due_date,
            'tenant_id' => $dto->tenant_id,
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total' => $total,
            'status'         => InvoiceStatusEnum::PENDING,
        ]);
    }
    public function recordPayment(RecordPaymentDTO $dto): Payment
    {
        $invoice = $this->invoiceRepo->getInvoiceById($dto->invoice_id);
        if (!$invoice) {
            throw new \Exception('Invoice not found');
        }
        if ($invoice->status === InvoiceStatusEnum::CANCELLED) {
            throw new \Exception('Cannot record payment for cancelled invoice');
        }
        return DB::transaction(function () use ($dto, $invoice) {
            $payment = $this->paymentRepo->createPayment([
                'invoice_id' => $dto->invoice_id,
                'amount' => $dto->amount,
                'payment_method' => $dto->payment_method,
                'reference_number' => $dto->reference_number,
                'paid_at' => now(),
            ]);
            $totalPaid = $this->paymentRepo->getTotalPaidForInvoice($dto->invoice_id);
            if ($totalPaid >= $invoice->total) {
                $this->invoiceRepo->updateInvoiceStatus($dto->invoice_id, InvoiceStatusEnum::PAID);
            } else {
                $this->invoiceRepo->updateInvoiceStatus($dto->invoice_id, InvoiceStatusEnum::PARTIALLY_PAID);
            }
            return $payment;
        });
    }
    public function getContractSummary(int $contractId): array
    {
        $totalInvoiced = $this->invoiceRepo->getTotalInvoicedForContract($contractId);

        $totalPaid = $this->paymentRepo->getTotalPaidForContract($contractId);
        $InvoiceCount = $this->invoiceRepo->getInvoicesCount($contractId);
        $latestInvoiceDate = $this->invoiceRepo->getLatestInvoiceDate($contractId);
        return [
            'contract_id'         => $contractId,
            'total_invoiced'      => $totalInvoiced,
            'total_paid'          => $totalPaid,
            'outstanding_balance' => round($totalInvoiced - $totalPaid, 2),
            'invoice_count'       => $InvoiceCount,
            'latest_invoice_date' => $latestInvoiceDate
        ];
    }
    private function generateInvoiceNumber(int $tenantId): string
    {
        $date = now()->format('Ym');
        $sequence = str_pad($this->invoiceRepo->getNextSequence($tenantId), 4, '0', STR_PAD_LEFT);

        //INV-001-202602-0001
        return sprintf("INV-%03d-%s-%s", $tenantId, $date, $sequence);
    }
}
