<?php

namespace App\Infra\Mapper;

use App\Domain\Entity\Company;
use App\Domain\ValueObject\Email;
use App\Infra\EloquentModel\CompanyModel;

class CompanyMapper
{
    public static function eloquentToCompany(CompanyModel $model): Company
    {
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
