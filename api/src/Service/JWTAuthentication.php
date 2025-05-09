<?php

namespace App\Service;

use App\Contract\Service\AuthenticationTokenInterface;
use App\Entity\Company;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class JWTAuthentication implements AuthenticationTokenInterface
{
    public function __construct(
        private JWTTokenManagerInterface $jwtManager,
        private JWTEncoderInterface $jwtEncoder,
        private Security $security
    ) {}

    public function createToken(UserInterface $user): string
    {
        return $this->jwtManager->create($user);
    }

    public function checkToken(string $token): bool
    {
        try {
            $this->jwtEncoder->decode($token);
            return !empty($payload);
        } catch (Exception) {
            return false;
        }
    }

    public function getUser(): ?Company
    {
        return $this->security->getUser();
    }
}
