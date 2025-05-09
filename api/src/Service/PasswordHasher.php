<?php

namespace App\Service;

use App\Contract\Service\PasswordHasherInterface as ServicePasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class PasswordHasher implements ServicePasswordHasherInterface
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    public function verify(PasswordAuthenticatedUserInterface $user, string $plainPassword): bool
    {
        return $this->hasher->isPasswordValid($user, $plainPassword);
    }

    public function hashPassword(PasswordAuthenticatedUserInterface $user, string $plainPassword): string
    {
        return $this->hasher->hashPassword($user, $plainPassword);
    }
}
