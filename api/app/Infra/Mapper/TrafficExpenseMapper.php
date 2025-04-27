<?php

namespace App\Infra\Mapper;

use App\Domain\Entity\TrafficExpense;
use App\Domain\ValueObject\Amount;
use App\Infra\EloquentModel\TrafficExpenseModel;
use Illuminate\Database\Eloquent\Collection;

class TrafficExpenseMapper
{
    public static function eloquentToEntity(TrafficExpenseModel $model, array $relations = []): TrafficExpense
    {
        return new TrafficExpense(
            $model->id,
            in_array('company', $relations)  ? CompanyMapper::eloquentToCompany($model->company) : null,
            in_array('trafficSource', $relations)  ?  TrafficSourceMapper::eloquentToEntity($model->trafficSource) : null,
            in_array('campaign', $relations)  ?  CampaignMapper::eloquentToCampaign($model->campaign) : null,
            $model->date,
            new Amount($model->amount)
        );
    }

    public static function eloquentCollectionToEntities(Collection $models, array $relations = []): array
    {
        return array_map(function ($model) use ($relations) {
            return self::eloquentToEntity($model, $relations);
        }, $models->all());
    }
}
