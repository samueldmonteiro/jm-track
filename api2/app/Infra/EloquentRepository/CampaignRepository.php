<?php

namespace App\Infra\EloquentRepository;

use App\Domain\Entity\Campaign;
use App\Domain\Entity\Company;
use App\Domain\Exception\CampaignNotFoundException;
use App\Domain\Repository\CampaignRepositoryInterface;
use App\Infra\EloquentModel\CampaignModel;
use App\Infra\Mapper\CampaignMapper;

class CampaignRepository implements CampaignRepositoryInterface
{
    public function findById(int $id, array $with = ['company']): ?Campaign
    {
        $model = CampaignModel::with($with)->find($id);

        if (!$model) return null;

        return CampaignMapper::eloquentToCampaign($model);
    }

    public function store(Campaign $campaign): Campaign
    {
        $model = CampaignMapper::campaignToEloquent($campaign);
        $model->save();

        return CampaignMapper::eloquentToCampaign($model);
    }

    public function delete(int $id): bool
    {
        return CampaignModel::destroy($id) ? true : false;
    }

    public function findByCompany(Company $company, array $with = []): array
    {
        $models = CampaignModel::with($with)->orderByDesc('id')
            ->where('company_id', $company->getId())->get();

        return CampaignMapper::eloquentCollectionToCampaigns($models, $with);
    }

    public function update(Campaign $campaign): Campaign
    {
        $model = CampaignModel::find($campaign->getId());

        $model->update([
            'name' => $campaign->getName()
        ]);

        return CampaignMapper::eloquentToCampaign($model);
    }

    public function findByIdAndByCompany(Company $company, int $id, array $with = []): Campaign
    {
        $model = CampaignModel::with($with)->where('company_id', $company->getId())->find($id);

        if (!$model) {
            throw new CampaignNotFoundException();
        }

        return CampaignMapper::eloquentToCampaign($model, $with);
    }
}
