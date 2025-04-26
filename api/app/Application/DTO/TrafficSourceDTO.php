<?php

namespace App\Application\DTO;

class TrafficSourceDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $image
    ) {}
}
