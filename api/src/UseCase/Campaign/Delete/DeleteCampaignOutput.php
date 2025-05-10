<?php

namespace App\UseCase\Campaign\Delete;

class DeleteCampaignOutput
{
    public function __construct(
        public bool $deleted
    ) {}
}
