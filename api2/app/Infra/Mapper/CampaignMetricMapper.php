<?php

namespace App\Infra\Mapper;

use App\Domain\Entity\CampaignMetric;
use App\Infra\EloquentModel\CampaignMetricModel;
use Illuminate\Database\Eloquent\Collection;

class CampaignMetricMapper
{
    public static function eloquentToEntity(CampaignMetricModel $model, array $relations = []): CampaignMetric
    {
        return new CampaignMetric(
            $model->id,
            $model->returning_customers,
            in_array('company', $relations)  ? CompanyMapper::eloquentToCompany($model->company) : null,
            in_array('campaign', $relations)  ?  CampaignMapper::eloquentToCampaign($model->campaign) : null,
            in_array('trafficSource', $relations)  ?  TrafficSourceMapper::eloquentToEntity($model->trafficSource) : null,
        );
    }

    public static function eloquentCollectionToEntities(Collection $models, array $relations = []): array
    {
        return array_map(function ($model) use ($relations) {
            return self::eloquentToEntity($model, $relations);
        }, $models->all());
    }

    public static function entityToEloquent(CampaignMetric $campaignMetric): CampaignMetricModel
    {
        $model = new CampaignMetricModel();
        $model->id = $campaignMetric->getId();
        $model->returningCustomers = $campaignMetric->getReturningCustomers();
        $model->company_id = $campaignMetric->getCompany()->getId();
        $model->traffic_source_id = $campaignMetric->getTrafficSource()->getId();
        $model->campaign_id = $campaignMetric->getCampaign()->getId();
        return $model;
    }
}
