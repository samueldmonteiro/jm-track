<?php

namespace App\Application\UseCase\Auth\AuthAdmin;

use App\Domain\Repository\AdminRepositoryInterface;
use App\Domain\Security\AuthTokenInterface;
use App\Domain\Security\PasswordHasherInterface;

class AuthAdminUseCase
{
    public function __construct(
        private AdminRepositoryInterface $adminRepository,
        private PasswordHasherInterface $hasher,
        private AuthTokenInterface $authToken
    ) {}

    public function execute(AuthAdminInputDTO $dto): ?AuthAdminOutputDTO
    {
        $admin = $this->adminRepository->findByEmail($dto->email);
        
        if (!$admin) return null;
 
        if (!$this->hasher->compare($admin->getPassword(), $dto->password)) {
            return null;
        }

        return new AuthAdminOutputDTO($this->authToken->generateToken($admin));
    }
}