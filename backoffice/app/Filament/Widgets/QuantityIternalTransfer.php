<?php

namespace App\Filament\Widgets;

use App\Models\ClientModel;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class QuantityIternalTransfer extends BaseWidget
{
    protected function getStats(): array
    {
        return [
//            Stat::make('Total de Dinheiro na plataforma', 'USDT ' . ClientModel::all()->where('status', 'active')->sum('balance_usdt'))
//                ->description('Soma Total De USDT')
//                ->descriptionIcon('heroicon-m-arrow-trending-up')
//                ->chart([7, 2, 10, 3, 15, 4, 17])
//                ->color('success'),
        ];
    }
}
