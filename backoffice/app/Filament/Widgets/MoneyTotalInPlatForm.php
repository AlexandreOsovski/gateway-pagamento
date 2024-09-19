<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\ClientModel;

class MoneyTotalInPlatForm extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total De Clientes Ativos', ClientModel::all()->where('status', 'active')->count())
                ->description('Todos Os Usuarios Ativos da Plataforma')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make('Total De Clientes Inativos', ClientModel::all()->where('status', 'inactive')->count())
                ->description('Todos Os Usuarios Inativos da Plataforma')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger'),

            Stat::make('Total de BRL na plataforma', 'R$ ' . ClientModel::all()->where('status', 'active')->sum('balance'))
                ->description('Soma Total Em BRL')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make('Total de Dinheiro na plataforma', 'USDT ' . ClientModel::all()->where('status', 'active')->sum('balance_usdt'))
                ->description('Soma Total De USDT')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),



        ];
    }
}
