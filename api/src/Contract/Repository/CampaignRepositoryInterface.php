<?php

namespace App\Contract\Repository;

use App\Domain\Exception\CampaignNotFoundException;
use App\Entity\Campaign;
use App\Entity\Company;
use App\Exception\CampaignDoesNotBelongToCompanyException;

interface CampaignRepositoryInterface
{
    /**
     * @throws CampaignNotFoundException
     */
    public function findById(int $id, bool $throw = true): ?Campaign;

    /**
     * @throws CampaignNotFoundException
     */
    public function findByIdForCompany(Company $company, int $id, bool $throw = true): ?Campaign;

    /** @throws CampaignDoesNotBelongToCompanyException */
    public function campaignBelongsToCompany(Company $company, Campaign $campaign, bool $throw = true): bool;

    public function create(Campaign $campaign, bool $throw = true): ?Campaign;
    public function update(Campaign $campaign, bool $throw = true): ?Campaign;
    public function delete(Campaign $campaign, bool $throw = true): bool;
}
