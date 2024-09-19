<?php

namespace App\Filament\Widgets;

use App\Models\AdminModel;
use App\Models\ClientModel;
use Filament\Infolists\Components\Section;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class QuantityIternalTransfer extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Balance Total do Admin', 'USDT ' . AdminModel::all()->sum('balance_usdt'))
                ->description('Soma Total De USDT')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make('Balance Total do Admin', 'R$ ' . AdminModel::all()->sum('balance'))
                ->description('Soma Total De BRL')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
        ];
    }
}
