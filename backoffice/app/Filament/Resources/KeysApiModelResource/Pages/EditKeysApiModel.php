<?php

namespace App\Filament\Resources\KeysApiModelResource\Pages;

use App\Filament\Resources\KeysApiModelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKeysApiModel extends EditRecord
{
    protected static string $resource = KeysApiModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
