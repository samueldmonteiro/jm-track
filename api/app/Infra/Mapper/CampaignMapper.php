<?php

namespace App\Infra\Mapper;

use App\Domain\Entity\Campaign;
use App\Domain\Enum\CampaignStatus;
use App\Infra\EloquentModel\CampaignModel;
use Illuminate\Database\Eloquent\Collection;

class CampaignMapper
{
    public static function eloquentToCampaign(CampaignModel $model, array $relations = []): Campaign
    {
        $status = match ($model->status) {
            'open' => CampaignStatus::OPEN,
            'closed' => CampaignStatus::CLOSED,
            'paused' => CampaignStatus::PAUSED,
        };

        return new Campaign(
            $model->id,
            in_array('company', $relations)  ? CompanyMapper::eloquentToCompany($model->company) : null,
            $model->name,
            $status,
            $model->start_date,
            $model->end_date,
        );
    }

    public static function campaignToEloquent(Campaign $campaign): CampaignModel
    {
        $status = match ($campaign->getStatus()) {
            CampaignStatus::OPEN => 'open',
            CampaignStatus::CLOSED => 'closed',
            CampaignStatus::PAUSED => 'paused',
        };

        $model = new CampaignModel();
        $model->id = $campaign->getId();
        $model->company_id = $campaign->getCompany()->getId();
        $model->name = $campaign->getName();
        $model->status = $status;
        $model->start_date = $campaign->getStartDate();
        $model->end_date = $campaign->getEndDate();
        return $model;
    }

    public static function eloquentCollectionToCampaigns(Collection $models, array $relations = []): array
    {
        $outputList = array_map(function (CampaignModel $model) use ($relations) {
            return self::eloquentToCampaign($model, $relations);
        }, $models->all());

        return $outputList;
    }
}
