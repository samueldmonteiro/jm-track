<?php

namespace App\UseCase\Auth\GetUser;

class GetUserOutput
{
    public function __construct(
        public object $user,
        public string $userType
    ) {}

    public function toArray(): array
    {
        return [
            'user' => $this->user,
            'userType' => $this->userType,
        ];
    }
}
