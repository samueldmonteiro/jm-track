<?php

namespace App\UseCase\Company\Create;

use App\Contract\Repository\CompanyRepositoryInterface;
use App\Contract\Service\PasswordHasherInterface;
use App\Domain\Exception\DocumentAlreadyExistsException;
use App\Domain\Exception\EmailAlreadyExistsException;
use App\Entity\Company;
use DateTimeImmutable;

class CreateCompany
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
        private PasswordHasherInterface $passwordHasher
    ) {}

    public function execute(CreateCompanyInput $input): CreateCompanyOutput
    {
        if ($this->companyRepository->findByDocument($input->document, false)) {
            throw new DocumentAlreadyExistsException();
        }

        if ($this->companyRepository->findByEmail($input->email, false)) {
            throw new EmailAlreadyExistsException();
        }

        $company = new Company(
            $input->name,
            $input->document,
            $input->email,
            $input->password,
            $input->phone,
            new DateTimeImmutable('now')
        );

        $company->setRoles(['ROLE_IS_COMPANY']);
        $company->setPassword($this->passwordHasher->hashPassword($company, $input->password));

        $this->companyRepository->create($company);
        return new CreateCompanyOutput($company);
    }
}
