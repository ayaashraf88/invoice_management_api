<?php

namespace App\Domain\Users\Repositories;

use App\Domain\Users\Dtos\LoginUserDTO;
use App\Domain\Users\Models\User;

class EloquentAuthRepository implements AuthRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
