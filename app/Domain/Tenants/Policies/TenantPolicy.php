<?php
namespace App\Domain\Tenants\Policies;

class TenantPolicy
{
    public function viewReport($user, $tenant)
    {
        return $user->tenant_id === $tenant->id;
    }
}