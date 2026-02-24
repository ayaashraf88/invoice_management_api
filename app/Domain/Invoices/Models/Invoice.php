<?
namespace App\Domain\Invoices\Models;

use App\Domain\Contracts\Models\Contract;
use App\Domain\Payments\Models\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Invoice extends Model{
     use HasFactory, Notifiable;
   protected $fillable = [
    'contract_id',
    'invoice_number',
    'subtotal',
    'tax_amount',
    'total',
    'status',
    ];
    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'paid_at' => 'datetime',
            'status' => \App\Domain\Invoices\Enums\InvoiceStatusEnum::class,
        ];
    }
    function Contract()  {
        return $this->belongsTo(Contract::class);
    }
    function Payments()  {
        return $this->hasMany(Payment::class);
    }
}
