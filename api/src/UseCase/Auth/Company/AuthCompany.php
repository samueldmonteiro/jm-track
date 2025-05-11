<?php

namespace App\UseCase\Auth\Company;

use App\Contract\Repository\CompanyRepositoryInterface;
use App\Contract\Service\AuthenticationTokenInterface;
use App\Contract\Service\PasswordHasherInterface;
use App\Exception\CompanyIncorrectLoginException;

class AuthCompany
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
        private AuthenticationTokenInterface $authenticationToken,
        private PasswordHasherInterface $passwordHasher
    ) {}

    public function execute(AuthCompanyInput $input): AuthCompanyOutput
    {
        $company = $this->companyRepository->findByDocument($input->document);

        if (!$this->passwordHasher->verify($company, $input->password)) {
            throw new CompanyIncorrectLoginException();
        }

        $token = $this->authenticationToken->createToken($company);

        return new AuthCompanyOutput(
            $token,
            $company
        );
    }
}
