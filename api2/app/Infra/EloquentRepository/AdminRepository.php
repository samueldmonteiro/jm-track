<?php

namespace App\Infra\EloquentRepository;

use App\Domain\Entity\Admin;
use App\Domain\Repository\AdminRepositoryInterface;
use App\Domain\ValueObject\Email;
use App\Infra\EloquentModel\AdminModel;

class AdminRepository implements AdminRepositoryInterface
{
    public function findByEmail(Email $email): ?Admin
    {
        $model = AdminModel::where('email', $email)->first();
        if(!$model) return null;

        return new Admin(
            $model->id,
            $model->username,
            $email,
            $model->password
        );
    }
}
