<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum DocumentType: string implements HasColor, HasIcon, HasLabel
{
    case CPF = 'CPF';

    case CNPJ = 'CNPJ';

    case CNH = 'CNH';


    public function getLabel(): string
    {
        return match ($this) {
            self::CPF => 'CPF',
            self::CNPJ => 'CNPJ',
            self::CNH => 'CNH',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::CPF => 'success',
            self::CNPJ => 'success',
            self::CNH => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::CPF => 'heroicon-o-credit-card',
            self::CNPJ => 'heroicon-o-credit-card',
            self::CNH => 'heroicon-o-credit-card',
        };
    }
}
