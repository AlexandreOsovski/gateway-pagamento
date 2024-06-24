<?php

namespace App\Filament\Resources\SupportModelResource\Pages;

use App\Filament\Resources\SupportModelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSupportModels extends ListRecords
{
    protected static string $resource = SupportModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
