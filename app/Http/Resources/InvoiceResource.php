<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'invoice_number'=>$this->invoice_number,
            'subtotal'=>$this->subtotal,
            'tax_amount'    =>$this->tax_amount, 
            'contract'       => new ContractResource($this->whenLoaded('contract')),
            'total'          => $this->total,
            'status'         => $this->status->value,
            'paid_at'       => $this->paid_at,
            'remaining_balance'=>$this->remaining_balance,
            'due_date' => $this->due_date,
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
        ];
    }
}
