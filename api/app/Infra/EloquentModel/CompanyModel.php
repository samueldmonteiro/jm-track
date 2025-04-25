<?php

namespace App\Infra\EloquentModel;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CompanyModel extends Authenticatable implements JWTSubject
{
    protected $table = 'companies';
    protected $fillable = [
        'name',
        'document',
        'phone',
        'email',
        'password',
        'created_at'
    ];

    public function getJWTIdentifier()
    {
        return $this->id;
    }

    public function getJWTCustomClaims()
    {
        return [
            'role' => 'company'
        ];
    }
}
