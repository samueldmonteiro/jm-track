<?php

namespace App\Domain\Security\AuthToken;

interface AuthTokenInterface
{
    public function verifyToken(string $token): bool;
    public function getToken(): string;
}
