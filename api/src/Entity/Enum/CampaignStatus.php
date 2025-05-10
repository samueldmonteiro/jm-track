<?php

namespace App\Entity\Enum;

enum CampaignStatus: string
{
    case PAUSED = 'pausado';
    case OPEN = 'aberto';
    case CLOSED = 'fechado';

    public function label(): string
    {
        return match($this) {
            self::PAUSED => 'Pausado',
            self::OPEN => 'Aberto',
            self::CLOSED => 'Fechado',
        };
    }
}

