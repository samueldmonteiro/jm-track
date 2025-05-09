<?php

namespace App\UseCase\Auth\GetUser;


class GetUserOutput
{
    public function __construct(
        public object $user,
        public string $type
    ) {}
}
