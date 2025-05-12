<?php

namespace App\UseCase\TrafficTransaction\Delete;

class DeleteTrafficTransactionOutput
{
    public function __construct(
        public bool $deleted
    ) {}
}