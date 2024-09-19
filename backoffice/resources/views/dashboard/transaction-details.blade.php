@extends('livewire.components.main')
@section('content')
    <div class="body-content">
        <div class="container">

            <div class="page-header">
                <div class="page-header-title page-header-item">
                    <h3>Detalhes da Transferência</h3>
                </div>
            </div>

            <div class="payment-list pb-15">
                <div class="payment-list-details">
                    <div class="payment-list-item payment-list-title">Data da Transação</div>
                    <div class="payment-list-item payment-list-info">
                        {{ \Carbon\Carbon::parse($transaction_detail['transaction_date'])->format('d/m/Y H:i:s') }}
                    </div>
                </div>

                <div class="payment-list-details">
                    <div class="payment-list-item payment-list-title">Cliente que Enviou</div>
                    <div class="payment-list-item payment-list-info">{{ $transaction_detail['client_send'] }}</div>
                </div>

                <div class="payment-list-details">
                    <div class="payment-list-item payment-list-title">Cliente que Recebeu</div>
                    <div class="payment-list-item payment-list-info">{{ $transaction_detail['client_received'] }}</div>
                </div>

                <div class="payment-list-details">
                    <div class="payment-list-item payment-list-title">Número da Transação</div>
                    <div class="payment-list-item payment-list-info">
                        {{ $transaction_detail['entry_transaction_number'] . $transaction_detail['exit_transaction_number'] }}
                    </div>
                </div>

                <div class="payment-list-details">
                    <div class="payment-list-item payment-list-title">Categoria da Transação</div>
                    @switch($transaction_detail['entry_type_movement'])
                        @case('TRANSFER')
                            <div class="payment-list-item payment-list-info">Transferência</div>
                        @break

                        @case('WITHDRAWAL')
                            <div class="payment-list-item payment-list-info">Saque</div>
                        @break

                        @case('DEPOSIT')
                            <div class="payment-list-item payment-list-info">Deposito</div>
                        @break
                    @endswitch

                </div>

                <div class="payment-list-details">
                    <div class="payment-list-item payment-list-title">Valor da Transação</div>
                    <div class="payment-list-item payment-list-info">
                        R$ {{ number_format($transaction_detail['amount'], 2, ',', '.') }}
                    </div>
                </div>
            </div>

            <!-- Payment-list -->
        </div>
    </div>
    <!-- Body-content -->
@endsection
