<?php

namespace App\Domain\Invoices\Models;

use App\Domain\Contracts\Models\Contract;
use App\Domain\Payments\Models\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Invoice extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'contract_id',
        'invoice_number',
        'subtotal',
        'tax_amount',
        'total',
        'status',
        'due_date',
        'paid_at',
    ];
    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'paid_at' => 'datetime',
            'status' => \App\Domain\Invoices\Enums\InvoiceStatusEnum::class,
        ];
    }
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function payments() 
    {
        return $this->hasMany(Payment::class);
    }
}
