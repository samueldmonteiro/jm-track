<?php

namespace App\Repository;

use App\Contract\Repository\TrafficTransactionRepositoryInterface;
use App\Entity\Company;
use App\Entity\TrafficTransaction;
use App\Exception\TrafficTransactionDoesNotBelongToCompanyException;
use App\Exception\TrafficTransactionNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TrafficTransactionRepository extends ServiceEntityRepository implements TrafficTransactionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrafficTransaction::class);
    }

    public function findAllForCompany(Company $company): array
    {
        $trafficTransactions = $this->createQueryBuilder('c')
            ->andWhere('c.company = :company')
            ->setParameter('company', $company)
            ->getQuery()
            ->getResult();

        return $trafficTransactions;
    }

    public function findById(int $id, bool $throw = true): ?TrafficTransaction
    {
        $trafficTransaction = $this->findOneBy(['id' => $id]);
        if (!$trafficTransaction && $throw) {
            throw new TrafficTransactionNotFoundException();
        }

        return $trafficTransaction;
    }

    public function create(TrafficTransaction $trafficTransaction, bool $throw = true): ?TrafficTransaction
    {
        $this->getEntityManager()->persist($trafficTransaction);
        $this->getEntityManager()->flush();
        return $trafficTransaction;
    }

    public function update(TrafficTransaction $trafficTransaction, bool $throw = true): ?TrafficTransaction
    {
        $this->getEntityManager()->persist($trafficTransaction);
        $this->getEntityManager()->flush();
        return $trafficTransaction;
    }

    public function delete(TrafficTransaction $trafficTransaction, bool $throw = true): bool
    {
        try {
            $this->getEntityManager()->remove($trafficTransaction);
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
     *  @throws TrafficTransactionDoesNotBelongToCompanyException
     */
    public function belongsToCompany(
        Company $company,
        TrafficTransaction $trafficTransaction,
        bool $throw = true
    ): bool
    {
        $result = $trafficTransaction->getCompany()->getId() == $company->getId();
        if (!$result && $throw) {
            throw new TrafficTransactionDoesNotBelongToCompanyException();
        }
        return $result;
    }
}
