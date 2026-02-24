<?php
namespace App\Domain\Contracts\Repositories;
use App\Domain\Contracts\Enums\ContractStatusEnum;
use App\Domain\Contracts\Models\Contract;
class EloquentContractRepository implements ContractRepositoryInterface {
    public function createContract(array $data): Contract {
        return Contract::create($data);
    }
    public function getContractById(int $id): ?Contract {
        return Contract::find($id);
    }
    public function updateContractStatus(int $id, ContractStatusEnum $status): ?Contract {
        $contract = Contract::find($id);
        if ($contract) {
            $contract->status = $status->value;
            $contract->save();
        }
        return $contract;
    }
    public function deleteContract(int $id): bool {
        $contract = Contract::find($id);
        if ($contract) {
            return $contract->delete();
        }
        return false;
    }
}