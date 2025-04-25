<?php

namespace App\Infra\Service;

use App\Domain\Security\PasswordHasherInterface;
use Illuminate\Support\Facades\Hash;

class PasswordHasher implements PasswordHasherInterface
{
    public function hasher(string $password): string
    {
        return Hash::make($password);
    }

    public function compare(string $hash, string $password): bool
    {
        return Hash::check($password, $hash);
    }
}