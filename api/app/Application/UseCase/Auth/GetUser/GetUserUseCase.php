<?php

namespace App\Application\UseCase\Auth\GetUser;

use App\Domain\Entity\Admin;
use App\Domain\Entity\Company;
use App\Domain\Security\AuthTokenInterface;

class GetUserUseCase
{
    public function __construct(
        private AuthTokenInterface $authToken
    ) {}

    public function execute(string $token): GetUserOutputDTO
    {
        $user = $this->authToken->getAuthUser($token);

        $userType = match (true) {
            $user instanceof Admin => 'admin',
            $user instanceof Company => 'company',
            default => throw new \InvalidArgumentException('Invalid user type'),
        };

        return new GetUserOutputDTO(
            $user,
            $userType
        );
    }
}
