<?php

namespace App\Infra\EloquentRepository;

use App\Domain\Entity\Company;
use App\Domain\Entity\TrafficReturn;
use App\Domain\Repository\TrafficReturnRepositoryInterface;
use App\Infra\EloquentModel\TrafficReturnModel;
use App\Infra\Mapper\TrafficReturnMapper;

class TrafficReturnRepository implements TrafficReturnRepositoryInterface
{
    public function findById(int $id, array $with = []): ?TrafficReturn
    {
        $model = TrafficReturnModel::with($with)->find($id);

        if(!$model) return null;

        return TrafficReturnMapper::eloquentToEntity($model, $with);
    }

    /** @return TrafficReturn[] */
    public function findAllByCompany(Company $company, array $with = []): array
    {
        $models = TrafficReturnModel::where('company_id', $company->getId())->get();

        return TrafficReturnMapper::eloquentCollectionToEntities($models, $with);
    }

    public function store(TrafficReturn $trafficReturn): TrafficReturn
    {
        $model = TrafficReturnMapper::entityToEloquent($trafficReturn);

        $model->save();

        return TrafficReturnMapper::eloquentToEntity($model);
    }
}
