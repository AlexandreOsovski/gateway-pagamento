<?php

namespace App\Filament\Resources;

use App\Filament\{
    Resources\TransactionModelResource\Pages,
    Resources\TransactionModelResource\RelationManagers,
};
use App\Models\TransactionModel;
use Filament\{
    Forms,
    Forms\Components\Select,
    Forms\Form,
    Resources\Resource,
    Tables,
    Tables\Columns\TextColumn,
    Tables\Table,
    Tables\Actions\Action,
    Notifications\Notification,
};
use Illuminate\Support\Facades\Http;
use App\Enums\StatusPix;

class TransactionModelResource extends Resource
{
    protected static ?string $model = TransactionModel::class;
    protected static ?string $label = 'Transações';
    protected static ?string $slug = 'transactions';
    protected static ?string $navigationIcon = 'tabler-transaction-dollar';
    protected static ?string $navigationGroup = 'Financeiro';

    public static function getNavigationBadge(): ?string
    {
        return TransactionModel::where('status', 'waiting_approval')->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('client_id')
                    ->label('Cliente')
                    ->relationship('client', 'name')
                    ->disabled()
                    ->reactive(),

                Forms\Components\TextInput::make('amount')->label('Valor')->prefix('R$ ')->disabled(),
                Forms\Components\TextInput::make('created_at')->label('Criado')->disabled()->mask('9999/99/99 99:99:99'),
                Forms\Components\TextInput::make('updated_at')->label('Alterado')->disabled()->mask('9999/99/99 99:99:99'),
                Forms\Components\ToggleButtons::make('status')
                    ->label('Status')
                    ->options(StatusPix::class)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->searchable()->sortable(),
                TextColumn::make('client.name')->label('Nome do Cliente')->searchable()->sortable(),
                TextColumn::make('type_key')->label('Tipo da chave PIX')->badge()->color('success')->searchable()->sortable(),
                TextColumn::make('address')->label('Chave PIX')->badge()->color('success')->searchable()->sortable(),
                TextColumn::make('amount')->label('Valor')->prefix('R$ ')->searchable()->sortable(),
                TextColumn::make('created_at')->label('Data Solicitação')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('approve')
                    ->label('Pagar Pix')
                    ->icon('heroicon-s-currency-dollar')
                    ->action(function ($record) {
                        $data = [
                            "id" => $record->id,
                            "client_id" => $record->client_id,
                            "amount" => $record->amount,
                            "pixKey" => $record->address,
                            "externalRef" => $record->client->uuid,
                        ];

                        $pixResponse = Http::withHeaders([
                            'authorizationAdmin' => env('KEY_TRANSFER_PIX'),
                            'accept' => 'application/json',
                            'content-type' => 'application/json',
                        ])->post(env('APP_URL') . '/api/pay-pix-in-admin', $data);

                        if ($pixResponse->successful()) {
                            Notification::make()
                                ->title('Pix pago com sucesso!')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Erro ao pagar saque!')
                                ->danger()
                                ->send();
                        }
                    })
                    ->button()
                    ->size('sm')
                    ->visible(fn ($record) => $record->status == 'waiting_approval')
                    ->color('success'),

                Tables\Actions\ViewAction::make()->label('Visualizar')
                    ->visible(fn ($record) => $record->status == 'approved'),
                Tables\Actions\EditAction::make()->label('Editar')
                    ->visible(fn ($record) => $record->status == 'waiting_approval'),
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
            'index' => Pages\ListTransactionModels::route('/'),
            //            'create' => Pages\CreateTransactionModel::route('/create'),
            //            'edit' => Pages\EditTransactionModel::route('/{record}/edit'),
        ];
    }
}