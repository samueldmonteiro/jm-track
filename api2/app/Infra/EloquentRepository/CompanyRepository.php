<?php

namespace App\Infra\EloquentRepository;

use App\Domain\Entity\Company;
use App\Domain\Repository\CompanyRepositoryInterface;
use App\Infra\EloquentModel\CampaignModel;
use App\Infra\EloquentModel\CompanyModel;
use App\Infra\Mapper\CompanyMapper;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function findById(int $id, array $with = []): ?Company
    {
        $model =  CompanyModel::with($with)->find($id);

        if (!$model) return null;

        return CompanyMapper::eloquentToCompany($model, $with);
    }

    public function findByDocument(string $document, array $with = []): ?Company
    {
        $model =  CompanyModel::with($with)->where('document', $document)->first();

        if (!$model) return null;

        return CompanyMapper::eloquentToCompany($model, $with);
    }

    public function campaignBelongsToCompany(int $campaignId, int $companyId): bool
    {
        return CampaignModel::find($campaignId)->company_id == CompanyModel::find($companyId)->id;
    }
}
