<?php

namespace App\Application\UseCase\Auth\GetUser;

class GetUserOutputDTO
{
    public function __construct(
        public array|object $user,
        public string $type
    ) {
        $this->user = $user->toArray();
    }
}
