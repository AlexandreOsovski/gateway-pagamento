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
use App\Models\MovementModel;

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
                    ->label('Pagar Pix Manual')
                    ->icon('heroicon-s-currency-dollar')
                    ->action(function ($record) {

                        $movement = new MovementModel();
                        $movement->client_id = $record->client_id;
                        $movement->type = 'EXIT';
                        $movement->type_movement = 'TRANSFER';
                        $movement->amount = $record->amount;
                        $movement->description = 'Admin aprovou sua solicitação de PIX. O valor será creditado em sua conta de destino em breve.';
                        $result = $movement->save();

                        $transaction = TransactionModel::where('id', $record->id)->first();

                        if ($result == 1) {
                            $transaction->status = 'approved';
                            Notification::make()
                                ->title('Pix pago com sucesso!')
                                ->success()
                                ->send();
                        } else {
                            $transaction->status = 'waiting_approval';
                            Notification::make()
                                ->title('Erro ao pagar saque!')
                                ->danger()
                                ->send();
                        }

                        $transaction->save();
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
