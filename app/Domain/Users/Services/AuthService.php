<?php
namespace App\Domain\Users\Services;

use App\Domain\Users\Repositories\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(private AuthRepositoryInterface $userRepo) {}

    public function authenticate(string $email, string $password): ?string
    {
        $user = $this->userRepo->findByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }

        return $user->createToken("tenant_{$user->tenant_id}_auth_token")->plainTextToken;
    }
}