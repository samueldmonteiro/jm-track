<?php

namespace App\Application\UseCase\Auth\AuthCompany;

use App\Domain\Repository\CompanyRepositoryInterface;
use App\Domain\Security\AuthToken\AuthTokenCompanyInterface;
use App\Domain\Security\PasswordHasherInterface;

class AuthCompanyUseCase
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
        private PasswordHasherInterface $hasher,
        private AuthTokenCompanyInterface $authToken
    ) {}

    public function execute(AuthCompanyInputDTO $dto): false|AuthCompanyOutputDTO
    {
        $company = $this->companyRepository->findByDocument($dto->document);

        if (!$company) return false;

        if (!$this->hasher->compare($company->getPassword(), $dto->password)) {
            return false;
        }

        return new AuthCompanyOutputDTO(
            $this->authToken->generateToken($company)
        );
    }
}
