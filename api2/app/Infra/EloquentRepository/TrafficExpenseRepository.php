<?php

namespace App\Infra\EloquentRepository;

use App\Domain\Entity\Company;
use App\Domain\Entity\TrafficExpense;
use App\Domain\Repository\TrafficExpenseRepositoryInterface;
use App\Infra\EloquentModel\TrafficExpenseModel;
use App\Infra\Mapper\TrafficExpenseMapper;

class TrafficExpenseRepository implements TrafficExpenseRepositoryInterface
{
    public function findById(int $id, array $with = []): ?TrafficExpense
    {
        $model = TrafficExpenseModel::with($with)->find($id);

        if(!$model) return null;

        return TrafficExpenseMapper::eloquentToEntity($model, $with);
    }

    /** @return TrafficExpense[] */
    public function findAllByCompany(Company $company, array $with = []): array
    {
        $models = TrafficExpenseModel::where('company_id', $company->getId())->get();

        return TrafficExpenseMapper::eloquentCollectionToEntities($models, $with);
    }

    public function store(TrafficExpense $trafficExpense): TrafficExpense
    {
        $model = TrafficExpenseMapper::entityToEloquent($trafficExpense);

        $model->save();

        return TrafficExpenseMapper::eloquentToEntity($model);
    }
}
