<?php

namespace App\Infra\EloquentRepository;

use App\Domain\Entity\Campaign;
use App\Domain\Repository\CampaignRepositoryInterface;
use App\Infra\EloquentModel\CampaignModel;
use App\Infra\Mapper\CampaignMapper;
use App\Infra\Mapper\CompanyMapper;
use DateTimeImmutable;

class CampaignRepository implements CampaignRepositoryInterface
{
    public function findById(int $id): ?Campaign
    {
        $model =  CampaignModel::find($id);

        if (!$model) return null;

        return CampaignMapper::eloquentToCampaign($model);
    }

    public function store(Campaign $campaign): Campaign {

        $model = CampaignMapper::campaignToEloquent($campaign);

        $model->save();

        return CampaignMapper::eloquentToCampaign($model);
    }
}
