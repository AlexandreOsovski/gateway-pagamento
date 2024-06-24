<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupportModelResource\Pages;
use App\Filament\Resources\SupportModelResource\RelationManagers;
use App\Models\ClientModel;
use App\Models\SupportModel;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\ToggleButtons;

class SupportModelResource extends Resource
{
    protected static ?string $model = SupportModel::class;
    protected static ?string $navigationLabel = 'Suporte';
    protected static ?string $label = 'Solicitações de suporte';
    protected static ?string $slug = 'supports';
    protected static ?string $navigationGroup = 'Suporte';
    protected static ?string $navigationIcon = 'eos-support-agent';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')->label('ID')->disabled(),
                Forms\Components\Select::make('client_id')
                    ->options(ClientModel::all()->pluck('name', 'id'))->label('Cliente')->disabled(),
                TextInput::make('email')->label('Email')->email()->disabled(),
                TextInput::make('title')->label('Titulo')->disabled(),
                Textarea::make('body')->label('Mensagem')->disabled(),
                TextInput::make('phone')->label('Telefone - Whatsapp')->disabled(),
                TextInput::make('created_at')->label('Criado')->disabled()->mask('9999/99/99 99:99:99'),
                TextInput::make('updated_at')->label('Alterado')->disabled()->mask('9999/99/99 99:99:99'),

                ToggleButtons::make('status')
                    ->options([
                        'novo' => 'Novo',
                        'respondido' => 'Respondido',
                    ])
                    ->icons([
                        'novo' => 'heroicon-s-bell-alert',
                        'respondido' => 'heroicon-s-check-circle',
                    ])
                    ->colors([
                        'novo' => 'warning',
                        'respondido' => 'success',
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->searchable()->sortable(),
                TextColumn::make('client.name')->label('Cliente')->searchable(),
                TextColumn::make('status')->searchable()
                    ->badge()
                    ->icons(['heroicon-s-bell-alert' => 'novo', 'heroicon-s-check-circle' => 'respondido'
                    ])
                    ->color(fn (string $state): string => match ($state) {
                        'novo' => 'warning',
                        'respondido' => 'success',
                    }),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('phone')->label('Telefone - Whatsapp')->searchable(),
                TextColumn::make('created_at')->label('Criado')->searchable(),
                TextColumn::make('updated_at')->label('Alterado')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Ver'),
                Tables\Actions\EditAction::make()->label('Editar'),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
            ])
            ;
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
            'index' => Pages\ListSupportModels::route('/'),
//            'create' => Pages\CreateSupportModel::route('/create'),
//            'edit' => Pages\EditSupportModel::route('/{record}/edit'),
        ];
    }
}
