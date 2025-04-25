<?php

namespace App\Infra\Mapper;

use App\Domain\Entity\Campaign;
use App\Domain\Enum\CampaignStatus;
use App\Infra\EloquentModel\CampaignModel;

class CampaignMapper
{
    public static function eloquentToCampaign(CampaignModel $model): Campaign
    {
        $status = match ($model->status) {
            'open' => CampaignStatus::OPEN,
            'closed' => CampaignStatus::CLOSED,
            'paused' => CampaignStatus::PAUSED,
        };

        return new Campaign(
            $model->id,
            CompanyMapper::eloquentToCompany($model->company),
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
}
