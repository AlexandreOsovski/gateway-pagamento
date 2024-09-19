<?php

namespace App\Filament\Resources\TransactionModelResource\Pages;

use App\Filament\Resources\TransactionModelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransactionModel extends EditRecord
{
    protected static string $resource = TransactionModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
