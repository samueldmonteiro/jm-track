<?php

namespace App\Application\DTO;

use DateTimeImmutable;

class TrafficExpenseWithoutRelationsDTO
{
    public function __construct(
        public DateTimeImmutable $date,
        public float $amount,
    ) {}
}
