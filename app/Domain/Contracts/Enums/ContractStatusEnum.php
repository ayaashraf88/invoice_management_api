<?php
namespace App\Domain\Contracts\Enums;
enum ContractStatusEnum: string {
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case EXPIRED = 'expired';
    case TERMINATED = 'terminated';
}
