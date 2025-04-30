<?php

namespace App\Infra\Mapper;

use App\Domain\Entity\TrafficReturn;
use App\Domain\ValueObject\Amount;
use App\Infra\EloquentModel\TrafficReturnModel;
use Illuminate\Database\Eloquent\Collection;

class TrafficReturnMapper
{
    public static function eloquentToEntity(TrafficReturnModel $model, array $relations = []): TrafficReturn
    {
        return new TrafficReturn(
            $model->id,
            $model->date,
            new Amount($model->amount),
            in_array('company', $relations) ? CompanyMapper::eloquentToCompany($model->company) : null,
            in_array('campaign', $relations) ? CampaignMapper::eloquentToCampaign($model->campaign) : null,
            in_array('trafficSource', $relations) ? TrafficSourceMapper::eloquentToEntity($model->trafficSource) : null,
        );
    }

    public static function entityToEloquent(TrafficReturn $entity): TrafficReturnModel
    {
        $model = new TrafficReturnModel();
        $model->id = $entity->getId();
        $model->date = $entity->getDate();
        $model->amount = $entity->getAmount()->getValue();
        $model->company_id = $entity->getCompany()->getId();
        $model->campaign_id = $entity->getCampaign()->getId();
        $model->traffic_source_id = $entity->getTrafficSource()->getId();
        return $model;
    }

    public static function eloquentCollectionToEntities(Collection $c, array $relations = []): array
    {
        return array_map(function ($tr) use ($relations) {
            return self::eloquentToEntity($tr, $relations);
        }, $c->all());
    }
}
