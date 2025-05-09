<?php

namespace App\Infra\EloquentRepository;

use App\Domain\Entity\TrafficSource;
use App\Domain\Repository\TrafficSourceRepositoryInterface;
use App\Infra\EloquentModel\TrafficSourceModel;
use App\Infra\Mapper\TrafficSourceMapper;

class TrafficSourceRepository implements TrafficSourceRepositoryInterface
{
    public function findByName(string $name): ?TrafficSource
    {
        $model = TrafficSourceModel::where('name', $name)->first();

        if (!$model) return null;

        return TrafficSourceMapper::eloquentToEntity($model);
    }

    public function findById(int $id): ?TrafficSource
    {
        $model = TrafficSourceModel::find($id);

        if (!$model) return null;

        return TrafficSourceMapper::eloquentToEntity($model);
    }

    /** @return TrafficSource[] */
    public function getAll(int $limit = 10): array
    {
        $models = TrafficSourceModel::all();

        return TrafficSourceMapper::eloquentCollectionToEntities($models);
    }
}
