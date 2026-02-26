<?php
namespace App\Domain\Users\Repositories;
use App\Domain\Users\Models\User;

interface AuthRepositoryInterface{
    public function findByEmail(string $email): ?User;
}