<?php

namespace App\UseCase\TrafficReturn\Delete;

class DeleteTrafficReturnOutput
{
    public function __construct(
        public bool $deleted
    ) {}
}