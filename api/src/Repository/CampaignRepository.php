<?php

namespace App\Repository;

use App\Contract\Repository\CampaignRepositoryInterface;
use App\Domain\Exception\CampaignNotFoundException;
use App\Entity\Campaign;
use App\Entity\Company;
use App\Exception\CampaignDoesNotBelongToCompanyException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

class CampaignRepository extends ServiceEntityRepository implements CampaignRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private CompanyRepository $companyRepository
    ) {
        parent::__construct($registry, Campaign::class);
    }

    public function findById(int $id, bool $throw = true): ?Campaign
    {
        $campaign = $this->findOneBy(['id' => $id]);

        if (!$campaign && $throw)  throw new CampaignNotFoundException();

        return $campaign;
    }

    public function findByIdForCompany(Company $company, int $id, bool $throw = true): ?Campaign
    {
        $campaign = $this->createQueryBuilder('c')
            ->andWhere('c.id = :id')
            ->andWhere('c.company = :company')
            ->setParameters(new ArrayCollection([
                'id' => $id,
                'company' => $company,
            ]))
            ->getQuery()
            ->getOneOrNullResult();

        if (!$campaign && $throw) {
            throw new CampaignNotFoundException();
        }

        return $campaign;
    }

    public function campaignBelongsToCompany(Company $company, Campaign $campaign, bool $throw = true): bool
    {
        $result = $campaign->getCompany()->getId() == $company->getId();
        if (!$result && $throw) {
            throw new CampaignDoesNotBelongToCompanyException();
        }
        return $result;
    }

    public function create(Campaign $campaign, bool $throw = true): ?Campaign
    {
        $this->getEntityManager()->persist($campaign);
        $this->getEntityManager()->flush();
        return $campaign;
    }

    public function update(Campaign $campaign, bool $throw = true): ?Campaign
    {
        $this->getEntityManager()->persist($campaign);
        $this->getEntityManager()->flush();
        return $campaign;
    }

    public function delete(Campaign $campaign, bool $throw = true): bool
    {
        try {
            $this->getEntityManager()->remove($campaign);
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception) {
            if ($throw) {
                throw new \Exception('Erro ao deletar Campanha', 500);
            }
            return false;
        }
    }
}
