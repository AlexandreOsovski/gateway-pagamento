<?php

namespace App\Filament\Resources\NotificationModelResource\Pages;

use App\Filament\Resources\NotificationModelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNotificationModel extends EditRecord
{
    protected static string $resource = NotificationModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
