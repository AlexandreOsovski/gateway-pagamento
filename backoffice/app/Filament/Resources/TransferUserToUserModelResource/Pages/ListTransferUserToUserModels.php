<?php

namespace App\Filament\Resources\TransferUserToUserModelResource\Pages;

use App\Filament\Resources\TransferUserToUserModelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransferUserToUserModels extends ListRecords
{
    protected static string $resource = TransferUserToUserModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
