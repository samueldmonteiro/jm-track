<?php

namespace App\Infra\Mapper;

use App\Domain\Entity\admin;
use App\Domain\Entity\Company;
use App\Infra\EloquentModel\adminModel;
use App\Infra\EloquentModel\CompanyModel;

class AuthUserMapper
{
    public static function adminToEloquent(Admin $admin): adminModel
    {
        $adminModel = new adminModel();
        $adminModel->id = $admin->getId();
        return $adminModel;
    }

    public static function companyToEloquent(Company $company): companyModel
    {
        $companyModel = new CompanyModel();
        $companyModel->id = $company->getId();
        return $companyModel;
    }
}
