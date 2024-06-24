<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasColor, HasIcon, HasLabel
{
    case ENTRY = 'ENTRY';

    case EXIT = 'EXIT';

//    case Shipped = 'shipped';
//
//    case Delivered = 'delivered';
//
//    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::ENTRY => 'ENTRADA',
            self::EXIT => 'SAIDA',
//            self::Shipped => 'Enviado',
//            self::Delivered => 'Entregue',
//            self::Cancelled => 'Cancelado',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ENTRY => 'success',
            self::EXIT => 'danger',
//            self::Shipped, self::Delivered => 'success',
//            self::Cancelled => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ENTRY => 'heroicon-s-arrow-down',
            self::EXIT => 'heroicon-s-arrow-up',
//            self::Shipped => 'heroicon-m-truck',
//            self::Delivered => 'heroicon-m-check-badge',
//            self::Cancelled => 'heroicon-m-x-circle',
        };
    }
}
