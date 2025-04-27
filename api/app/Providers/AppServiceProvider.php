<?php

namespace App\Providers;

use App\Domain\Repository\AdminRepositoryInterface;
use App\Domain\Repository\CampaignRepositoryInterface;
use App\Domain\Repository\CompanyRepositoryInterface;
use App\Domain\Repository\TrafficExpenseRepositoryInterface;
use App\Domain\Repository\TrafficSourceRepositoryInterface;
use App\Domain\Security\AuthToken\AuthTokenAdminInterface;
use App\Domain\Security\AuthToken\AuthTokenCompanyInterface;
use App\Domain\Security\PasswordHasherInterface;
use App\Infra\EloquentRepository\AdminRepository;
use App\Infra\EloquentRepository\CampaignRepository;
use App\Infra\EloquentRepository\CompanyRepository;
use App\Infra\EloquentRepository\TrafficExpenseRepository;
use App\Infra\EloquentRepository\TrafficSourceRepository;
use App\Infra\Security\JWT\JWTAuthAdmin;
use App\Infra\Security\JWT\JWTAuthCompany;
use App\Infra\Service\PasswordHasher;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // auth token
        $this->app->bind(AuthTokenAdminInterface::class, JWTAuthAdmin::class);
        $this->app->bind(AuthTokenCompanyInterface::class, JWTAuthCompany::class);

        // security
        $this->app->bind(PasswordHasherInterface::class, PasswordHasher::class);

        // repository
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(CampaignRepositoryInterface::class, CampaignRepository::class);
        $this->app->bind(TrafficSourceRepositoryInterface::class, TrafficSourceRepository::class);
        $this->app->bind(TrafficExpenseRepositoryInterface::class, TrafficExpenseRepository::class);


    }

    public function boot(): void {}
}
