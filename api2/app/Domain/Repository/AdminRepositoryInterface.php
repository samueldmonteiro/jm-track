<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Admin;
use App\Domain\ValueObject\Email;

interface AdminRepositoryInterface
{
    public function findByEmail(Email $email): ?Admin;
}
