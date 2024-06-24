<?php

namespace App\Filament\Resources\NotificationModelResource\Pages;

use App\Filament\Resources\NotificationModelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNotificationModels extends ListRecords
{
    protected static string $resource = NotificationModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Cadastrar'),
        ];
    }
}
