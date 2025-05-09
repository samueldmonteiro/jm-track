<?php

namespace App\UseCase\Auth\GetUser;

use App\Contract\Service\AuthenticationTokenInterface;

class GetUser
{
    public function __construct(
        private AuthenticationTokenInterface $authentication
    ) {}

    public function execute(): GetUserOutput
    {
        $user = $this->authentication->getUser();

        return new GetUserOutput($user, 'company');
    }
}
