<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'contract'       => new ContractResource($this->whenLoaded('contract')),
            'total'          => $this->total,
            'status'         => $this->status->value,
            'due_date' => $this->due_date,
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
        ];
    }
}
