<?php

namespace App\Domain\Enum;

enum CampaignStatus: string
{
    case OPEN = 'open';
    case PAUSED = 'paused';
    case CLOSED = 'closed';
}
