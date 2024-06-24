<?php

namespace App\Filament\Resources\ClientModelResource\Pages;

use App\Filament\Resources\ClientModelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClientModel extends EditRecord
{
    protected static string $resource = ClientModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Deletar'),
        ];
    }
}
