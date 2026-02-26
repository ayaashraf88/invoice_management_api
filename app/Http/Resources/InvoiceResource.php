<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,
            'subtotal' => (float) $this->subtotal, // Cast to float
            'tax_amount' => (float) $this->tax_amount,
            'total' => (float) $this->total,
            'status' => $this->status,
            'due_date' => $this->due_date?->format('Y-m-d'), // Format as 2026-12-31
            'paid_at' => $this->paid_at?->format('Y-m-d H:i:s'),
            
            // Computed field: Total - sum of payments
            'remaining_balance' => (float) ($this->total - ($this->payments_sum_amount ?? 0)),

            // Relationships
            'contract' => new ContractResource($this->whenLoaded('contract')),
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
        ];
    }
}