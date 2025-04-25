<?php

namespace App\Infra\EloquentRepository;

use App\Domain\Entity\Company;
use App\Domain\Repository\CompanyRepositoryInterface;
use App\Domain\ValueObject\Email;
use App\Infra\EloquentModel\CompanyModel;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function findById(int $id): ?Company
    {
        $model =  CompanyModel::find($id);

        if(!$model) return null;

        return new Company(
            $model->id,
            $model->name,
            $model->document,
            new Email($model->email),
            $model->phone,
            $model->password,
        );
    }

    public function findByDocument(string $document): ?Company
    {
        $model =  CompanyModel::where('document', $document)->first();

        if(!$model) return null;

        return new Company(
            $model->id,
            $model->name,
            $model->document,
            new Email($model->email),
            $model->phone,
            $model->password,
        );
    }
}
