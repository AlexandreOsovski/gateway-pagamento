<?php

namespace App\Filament\Resources\MovementsModelResource\Pages;

use App\Filament\Resources\MovementsModelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMovementsModels extends ListRecords
{
    protected static string $resource = MovementsModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
