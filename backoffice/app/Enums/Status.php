<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasColor, HasIcon, HasLabel
{
    case ENTRY = 'ENTRY';

    case EXIT = 'EXIT';


    public function getLabel(): string
    {
        return match ($this) {
            self::ENTRY => 'ENTRADA',
            self::EXIT => 'SAIDA',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ENTRY => 'success',
            self::EXIT => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ENTRY => 'heroicon-s-arrow-down',
            self::EXIT => 'heroicon-s-arrow-up',
        };
    }
}
