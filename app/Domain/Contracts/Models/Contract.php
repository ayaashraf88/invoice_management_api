<?php
namespace App\Domain\Contracts\Models;

use App\Domain\Invoices\Models\Invoice;
use App\Domain\Tenants\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contract extends Model{
     use HasFactory, Notifiable;
    protected $fillable = [
        'tenant_id',
        'unit_name',
        'customer_name',
        'rent_amount',
        'start_date',
        'end_date',
        'status',
    ];
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => \App\Domain\Contracts\Enums\ContractStatusEnum::class,
        ];
    }
    function Tenant()  {
        return $this->belongsTo(Tenant::class);
    }
    function Invoice()  {
        return $this->hasMany(Invoice::class);
    }
}