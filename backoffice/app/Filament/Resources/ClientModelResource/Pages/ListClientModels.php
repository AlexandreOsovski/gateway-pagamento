<?php

namespace App\Filament\Resources\ClientModelResource\Pages;

use App\Filament\Resources\ClientModelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientModels extends ListRecords
{
    protected static string $resource = ClientModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
