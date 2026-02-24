<?php

namespace App\Http\Requests;

use App\Domain\Contracts\Dtos\CreateInvoiceDTO;
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
            'contract_id' => [
                'required',
                Rule::exists('contracts', 'id')->where('tenant_id', auth()->user()->tenant_id)
            ],
            'due_date' => 'required|date',
        ];
    }
    public function toDTO(): CreateInvoiceDTO
    {
        return CreateInvoiceDTO::fromRequest($this);
    }
}
