<?php

namespace Database\Seeders;

use App\Domain\Contracts\Models\Contract;
use App\Domain\Tenants\Models\Tenant;
use App\Domain\Users\Models\User as ModelsUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $tenant = Tenant::factory()->create();
        ModelsUser::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'tenant_id' => $tenant->id,
            
        ]);
        $contract = Contract::factory()->create([
            'tenant_id' => $tenant->id,
            'status' => 'active',
        ]);
    }
}
