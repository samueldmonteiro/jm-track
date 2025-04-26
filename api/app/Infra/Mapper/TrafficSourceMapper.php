<?php

namespace App\Infra\Mapper;

use App\Domain\Entity\TrafficSource;
use App\Infra\EloquentModel\TrafficSourceModel;
use Illuminate\Database\Eloquent\Collection;

class TrafficSourceMapper
{
    public static function eloquentToEntity(TrafficSourceModel $model): TrafficSource
    {
        return new TrafficSource(
            $model->id,
            $model->name,
            $model->image,
        );
    }

    public static function eloquentCollectionToEntities(Collection $models): array
    {
        return array_map(function ($model) {
            return self::eloquentToEntity($model);
        }, $models->all());
    }
}
