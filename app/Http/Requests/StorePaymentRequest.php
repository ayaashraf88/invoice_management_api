<?php
namespace App\Http\Requests;

use App\Domain\Payments\Dtos\RecordPaymentDTO;
use App\Domain\Payments\Enums\PaymentMethodEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => ['required', new Enum(PaymentMethodEnum::class)],
            'reference_number' => 'required|string|max:255',
        ];
    }
   
}
