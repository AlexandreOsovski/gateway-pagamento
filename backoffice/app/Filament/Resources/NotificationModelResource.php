<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotificationModelResource\Pages;
use App\Filament\Resources\NotificationModelResource\RelationManagers;
use App\Models\ClientModel;
use App\Models\NotificationModel;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Columns\SelectColumn;
use function Laravel\Prompts\select;

class NotificationModelResource extends Resource
{
    protected static ?string $model = NotificationModel::class;
    protected static ?string $label = 'Notificações';
    protected static ?string $slug = 'notifications';
    protected static ?string $navigationIcon = 'fas-bell';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('client_id')
                    ->options(ClientModel::all()->pluck('name', 'id'))
                    ->label('Cliente (apenas se for notificação destinada a um cliente específico)'),

                Forms\Components\TextInput::make('title')->label('Titulo')->required(),
                RichEditor::make('body')
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])->label('Mensagem')->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable()->label('ID')->sortable(),
                TextColumn::make('client.name')->searchable()->label('Cliente'),
                TextColumn::make('title')->searchable()->label('Titulo'),
                SelectColumn::make('status')
                    ->options([
                        '1' => 'Visualizado',
                        '0' => 'Enviado',
                    ]),
                TextColumn::make('created_at')->searchable()->label('Criado'),
                TextColumn::make('updated_at')->searchable()->label('Alterado'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Ver'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListNotificationModels::route('/'),
//            'create' => Pages\CreateNotificationModel::route('/create'),
//            'edit' => Pages\EditNotificationModel::route('/{record}/edit'),
        ];
    }
}
