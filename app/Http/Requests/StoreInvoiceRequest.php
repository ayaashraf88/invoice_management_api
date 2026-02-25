<?php

namespace App\Http\Requests;

use App\Domain\Invoices\Dtos\CreateInvoiceDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'due_date' => 'required|date',
        ];
    }
    public function toDTO(\App\Domain\Contracts\Models\Contract $contract): CreateInvoiceDTO
    {
        return CreateInvoiceDTO::fromRequest($this,$contract);
    }
}
