<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum UserStatus: string implements HasColor, HasIcon, HasLabel
{
    case ACTIVE = 'ACTIVE';

    case DESACTIVE = 'DESACTIVE';


    public function getLabel(): string
    {
        return match ($this) {
            self::ACTIVE => 'ATIVO',
            self::DESACTIVE => 'DESATIVADO'
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::DESACTIVE => 'danger'
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ACTIVE => 'heroicon-s-check-circle',
            self::DESACTIVE => 'heroicon-s-x-circle'
        };
    }
}
