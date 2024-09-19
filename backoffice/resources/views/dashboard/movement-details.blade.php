@extends('livewire.components.main')
@section('content')
    <div class="body-content">
        <div class="container">

            <div class="page-header">
                <div class="page-header-title page-header-item">
                    <h3>Detalhes da Conversão</h3>
                </div>
            </div>

            <div class="payment-list pb-15">
                <div class="payment-list-details">
                    <div class="payment-list-item payment-list-title">Data da Conversão</div>
                    <div class="payment-list-item payment-list-info">
                        {{ \Carbon\Carbon::parse($movement_detail['created_at'])->format('d/m/Y H:i:s') }}
                    </div>
                </div>


                <div class="payment-list-details">
                    <div class="payment-list-item payment-list-title">Número da Transação</div>
                    <div class="payment-list-item payment-list-info">
                        {{ $movement_detail['uuid'] }}
                    </div>
                </div>

                <div class="payment-list-details">
                    <div class="payment-list-item payment-list-title">Categoria da Transação</div>
                    <div class="payment-list-item payment-list-info">{{$movement_detail['description']}}</div>

                </div>

                <div class="payment-list-details">
                    <div class="payment-list-item payment-list-title">Valor da Transação</div>
                    <div class="payment-list-item payment-list-info">
                        @if($movement_detail['type_movement'] == 'CONVERSION')
                            USDT {{ number_format($movement_detail['amount'], 2, '.', ',') }}
                        @else
                            R$ {{ number_format($movement_detail['amount'], 2, '.', ',') }} <br>
                            (Valor total retirando TODAS as taxas)
                        @endif

                    </div>
                </div>
            </div>

            <!-- Payment-list -->
        </div>
    </div>
    <!-- Body-content -->
@endsection
