<?php

namespace App\UseCase\Company\Create;

class CreateCompanyInput
{
    public function __construct(
        public string $name,
        public string $document,
        public string $phone,
        public string $email,
        public string $password,
    ) {}
}
