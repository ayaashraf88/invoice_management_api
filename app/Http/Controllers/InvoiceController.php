<?php

namespace App\Http\Controllers;

use App\Domain\Contracts\Models\Contract;
use App\Domain\Invoices\Dtos\CreateInvoiceDTO;
use App\Domain\Invoices\Facades\InvoiceManagementFacade;
use App\Domain\Invoices\Models\Invoice;
use App\Domain\Invoices\Repositories\InvoiceRepositoryInterface;
use App\Domain\Invoices\Services\InvoiceService;
use App\Domain\Payments\Dtos\RecordPaymentDTO;
use App\Domain\Payments\Models\Payment;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\ContractSummaryResource;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\PaymentResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    use AuthorizesRequests;
    public function __construct(protected InvoiceManagementFacade $invoiceFacade, private InvoiceRepositoryInterface $invoiceRepo) {}
    public function store(StoreInvoiceRequest $request, Contract $contract)
    {
        $this->authorize('create', $contract);
        $dto = CreateInvoiceDTO::fromRequest($request, $contract);
        $invoice = $this->invoiceFacade->createInvoice($dto);
        return new InvoiceResource($invoice);
    }
    public function listInvoices(Contract $contract, Request $request)
    {
        $this->authorize('view', $contract);
        $invoices = Invoice::where("contract_id", $contract->id)->when($request->query('status'), function ($query, $status) {
            $query->where('status', $status);
        })
            ->when($request->query('from'), function ($query, $from) {
                $query->whereDate('due_date', '>=', $from);
            })
            ->when($request->query('search'), function ($query, $search) {
                $query->where('invoice_number', 'like', "%{$search}%");
            })
            ->withSum('payments', 'amount')
            ->get();
        return InvoiceResource::collection($invoices);
    }
    public function getInvoice(Invoice $invoice)
    {
        $this->authorize('view', $invoice);
        $invoice->load(['contract', 'payments']);
        return new InvoiceResource($invoice);
    }
    public function recordPayment(StorePaymentRequest $request, Invoice $invoice)
    {
        $this->authorize('recordPayment', $invoice);
        $dto = RecordPaymentDTO::fromRequest($request, $invoice);
        $payment = $this->invoiceFacade->recordPayment($dto);
        return new PaymentResource($payment);
    }
    public function summary(Contract $contract)
    {
        $this->authorize('view', $contract);
        $summary = $this->invoiceFacade->getContractSummary($contract->id);
        return new ContractSummaryResource($summary);
    }
}
