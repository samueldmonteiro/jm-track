<?php

namespace App\Domain\Security;

interface PasswordHasherInterface
{
    public function hasher(string $password): string;
    public function compare(string $hash, string $password): bool;
}
