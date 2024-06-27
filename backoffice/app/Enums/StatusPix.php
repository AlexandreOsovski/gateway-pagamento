<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusPix: string implements HasColor, HasIcon, HasLabel
{
    case waiting_approval = 'waiting_approval';

    case approved = 'approved';

    public function getLabel(): string
    {
        return match ($this) {
            self::waiting_approval => 'AGUARDANDO ADMIN',
            self::approved => 'APROVADO ADMIN',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::waiting_approval => 'warning',
            self::approved => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::waiting_approval => 'carbon-close-filled',
            self::approved => 'heroicon-s-check-circle',
        };
    }
}
