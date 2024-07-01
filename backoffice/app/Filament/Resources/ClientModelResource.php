<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientModelResource\Pages;
use App\Filament\Resources\ClientModelResource\RelationManagers;
use App\Models\ClientModel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Enums\DocumentType;
use App\Enums\UserStatus;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;
use Filament\Forms\Components\ToggleButtons;

class ClientModelResource extends Resource
{
    protected static ?string $model = ClientModel::class;

    protected static ?string $label = 'Clientes';
    protected static ?string $slug = 'clients';
    protected static ?string $navigationIcon = 'fas-user-friends';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('uuid')->label('UUID'),
                TextInput::make('name')->label('Nome'),
                TextInput::make('email')->label('E-mail'),
                ToggleButtons::make('document_type')->options(DocumentType::class),
                TextInput::make('document_number')->label('Numero do documento'),
                // ToggleButtons::make('status')->options(UserStatus::class),
                TextInput::make('created_at')->label('Criado')->mask('9999/99/99 99:99:99')->readOnly()->disabled(),
                TextInput::make('updated_at')->label('Alterado')->mask('9999/99/99 99:99:99')->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable()->label('ID')->sortable(),
                TextColumn::make('name')->searchable()->label('Nome'),
                TextColumn::make('email')->searchable()->label('E-mail'),
                TextColumn::make('document_number')->searchable()->label('Documento'),
                TextColumn::make('status')->searchable()->label('Status'),
                TextColumn::make('created_at')->searchable()->label('Criado')->dateTime(),
                TextColumn::make('updated_at')->searchable()->label('Alterado')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Impersonate::make('impersonate')
                    ->guard('client')
                    ->label('Acessar usuario')
                    ->redirectTo(route('dashboard.get')),
                Tables\Actions\EditAction::make()->label('Editar'),
                Tables\Actions\DeleteAction::make()->label('Excluir'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Excluir'),
                ])->label('Ações'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientModels::route('/'),
            //            'create' => Pages\CreateClientModel::route('/create'),
            //            'edit' => Pages\EditClientModel::route('/{record}/edit'),
        ];
    }
}