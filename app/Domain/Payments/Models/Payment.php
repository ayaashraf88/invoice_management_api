<?php
namespace App\Domain\Payments\Models;

use App\Domain\Invoices\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Payment extends Model{
     use HasFactory, Notifiable;
    protected $fillable = [
        'invoice_id',
        'amount',
        'payment_method',
        'reference_number',
        'paid_at',
    ];
    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
            'payment_method' => \App\Domain\Payments\Enums\PaymentMethodEnum::class,
        ];
    }
    function Invoice()  {
        return $this->belongsTo(Invoice::class);
    }
}