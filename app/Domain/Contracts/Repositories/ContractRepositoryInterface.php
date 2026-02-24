<?php
namespace App\Domain\Contracts\Repositories;
use App\Domain\Contracts\Enums\ContractStatusEnum;
use App\Domain\Contracts\Models\Contract;
interface ContractRepositoryInterface {
    public function createContract(array $data): Contract;
    public function getContractById(int $id): ?Contract;
    public function updateContractStatus(int $id, ContractStatusEnum $status): ?Contract;
    public function deleteContract(int $id): bool;
}
