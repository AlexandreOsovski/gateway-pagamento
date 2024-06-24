<?php

namespace App\Filament\Resources\ClientModelResource\Pages;

use App\Filament\Resources\ClientModelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientModels extends ListRecords
{
    protected static string $resource = ClientModelResource::class;

    protected static ?string $label = 'Novo Cliente';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Cadastrar'),
        ];
    }
}
