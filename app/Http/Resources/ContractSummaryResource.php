<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Request;

class ContractResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'contract_id'          => $this->contract_id,
            'total_invoiced' => $this->contract_id,
            'total_paid' => $this->total_paid,
            'outstanding_balance' => $this->outstanding_balance,
            'invoices_count' => $this->invoices_count,
            'latest_invoice_date' => $this->latest_invoice_date
        ];
    }
}
