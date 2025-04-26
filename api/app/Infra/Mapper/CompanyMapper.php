<?php

namespace App\Infra\Mapper;

use App\Domain\Entity\Campaign;
use App\Domain\Entity\Company;
use App\Domain\ValueObject\Email;
use App\Infra\EloquentModel\CompanyModel;

class CompanyMapper
{
    public static function eloquentToCompany(CompanyModel $model, array $relations = []): Company
    {
        if(in_array('campaigns', $relations)){
            $campaigns = CampaignMapper::eloquentCollectionToCampaigns($model->campaigns);
        }

        return new Company(
            $model->id,
            $model->name,
            $model->document,
            new Email($model->email),
            $model->phone,
            $model->password,
            $campaigns ?? []
        );
    }
}
