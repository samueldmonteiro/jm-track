<?php

namespace App\Entity\Enum;

enum TrafficTransactionType: string
{
    case EXPENSE = 'expense';
    case RETURN = 'return';
}

