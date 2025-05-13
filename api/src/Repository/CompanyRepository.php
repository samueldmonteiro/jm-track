<?php

namespace App\Repository;

use App\Contract\Repository\CompanyRepositoryInterface;
use App\Exception\CompanyNotFoundException;
use App\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;


class CompanyRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, CompanyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function findById(int $id, bool $throw = true): ?Company
    {
        $company = $this->findOneBy(['id' => $id]);

        if (!$company && $throw)  throw new CompanyNotFoundException();
        
        return $company;
    }

    public function findByDocument(string $document, bool $throw = true): ?Company
    {
        $company = $this->findOneBy(['document' => $document]);

        if (!$company && $throw)  throw new CompanyNotFoundException();
        
        return $company;
    }

    public function findByEmail(string $email, bool $throw = true): ?Company
    {
        $company = $this->findOneBy(['email' => $email]);

        if (!$company && $throw)  throw new CompanyNotFoundException();
        
        return $company;
    }

    public function create(Company $company, bool $throw = true): ?Company
    {
        $this->getEntityManager()->persist($company);
        $this->getEntityManager()->flush();
        return $company;
    }


    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Company) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
}
