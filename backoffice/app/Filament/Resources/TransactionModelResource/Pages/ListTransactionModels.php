<?php

namespace App\Filament\Resources\TransactionModelResource\Pages;

use App\Filament\Resources\TransactionModelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactionModels extends ListRecords
{
    protected static string $resource = TransactionModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
