<?php

namespace App\Filament\Resources\KeysApiModelResource\Pages;

use App\Filament\Resources\KeysApiModelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKeysApiModels extends ListRecords
{
    protected static string $resource = KeysApiModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
