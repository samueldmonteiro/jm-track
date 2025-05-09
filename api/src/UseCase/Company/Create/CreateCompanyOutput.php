<?php

namespace App\UseCase\Company\Create;

use App\Entity\Company;

class CreateCompanyOutput
{
    public function __construct(
        public Company $company
    ) {}
}
