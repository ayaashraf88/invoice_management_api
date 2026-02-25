<?php
namespace App\Domain\Tenants\Models;

use App\Domain\Contracts\Models\Contract;
use Database\Factories\TenantFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Tenant extends Model{
     use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'slug',
    ];
    function Contracts()  {
        return $this->hasMany(Contract::class);
    }
    protected static function newFactory()
    {
        return TenantFactory::new();
    }
}