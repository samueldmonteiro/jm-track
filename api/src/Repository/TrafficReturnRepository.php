<?php

namespace App\Repository;

use App\Contract\Repository\TrafficReturnRepositoryInterface;
use App\Entity\Company;
use App\Entity\TrafficReturn;
use App\Exception\TrafficReturnDoesNotBelongToCompanyException;
use App\Exception\TrafficReturnNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TrafficReturnRepository extends ServiceEntityRepository implements TrafficReturnRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrafficReturn::class);
    }

    public function findAllForCompany(Company $company): array
    {
        $trafficReturns = $this->createQueryBuilder('c')
            ->andWhere('c.company = :company')
            ->setParameter('company', $company)
            ->getQuery()
            ->getResult();

        return $trafficReturns;
    }

    public function findById(int $id, bool $throw = true): ?TrafficReturn
    {
        $trafficReturn = $this->findOneBy(['id' => $id]);
        if (!$trafficReturn && $throw) {
            throw new TrafficReturnNotFoundException();
        }

        return $trafficReturn;
    }

    public function create(TrafficReturn $trafficReturn, bool $throw = true): ?TrafficReturn
    {
        $this->getEntityManager()->persist($trafficReturn);
        $this->getEntityManager()->flush();
        return $trafficReturn;
    }

    public function update(TrafficReturn $trafficReturn, bool $throw = true): ?TrafficReturn
    {
        $this->getEntityManager()->persist($trafficReturn);
        $this->getEntityManager()->flush();
        return $trafficReturn;
    }

    public function delete(TrafficReturn $trafficReturn, bool $throw = true): bool
    {
        try {
            $this->getEntityManager()->remove($trafficReturn);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception) {
            if ($throw) {
                throw new \Exception('Erro ao deletar Campanha', 500);
            }
            return false;
        }
    }

    /**
     *  @throws TrafficReturnDoesNotBelongToCompanyException
     */
    public function belongsToCompany(
        Company $company,
        TrafficReturn $trafficReturn,
        bool $throw = true
    ): bool
    {
        $result = $trafficReturn->getCompany()->getId() == $company->getId();
        if (!$result && $throw) {
            throw new TrafficReturnDoesNotBelongToCompanyException();
        }
        return $result;
    }
}
