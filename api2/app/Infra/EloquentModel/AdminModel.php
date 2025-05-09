<?php

namespace App\Infra\EloquentModel;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class AdminModel extends Authenticatable implements JWTSubject
{
    protected $table = 'admins';
    protected $fillable = ['username', 'email', 'password'];

    public function getJWTIdentifier()
    {
        return $this->id;
    }

    public function getJWTCustomClaims()
    {
        return [
            'role' => 'admin'
        ];
    }
}
