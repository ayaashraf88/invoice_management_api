<?php

namespace App\Domain\Contracts\Policies;

use App\Domain\Contracts\Models\Contract;
use App\Domain\Tenants\Models\Tenant;
use App\Domain\Users\Models\User;

class ContractPolicy
{
    public function view(User $user, Contract $contract): bool
    {
        return $user->tenant_id === $contract->tenant_id;
    }
    public function create(User $user): bool
    {
        return true;
    }
    public function update(User $user, Contract $contract): bool
    {
        return $user->tenant_id === $contract->tenant_id;
    }
    public function delete(User $user, Contract $contract): bool
    {
        return $user->tenant_id === $contract->tenant_id;
    }
}
