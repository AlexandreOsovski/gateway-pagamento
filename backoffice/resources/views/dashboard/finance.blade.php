@extends('livewire.components.main')
@section('title', 'Financeiro')
@section('content')
    <!-- Body-content -->
    <div class="body-content">
        <div class="feature-section mb-15">
            <div class="row gx-3">
                <div class="col col-sm-6 pb-15">
                    <div class="feature-card feature-card-red">
                        <div class="feature-card-thumb">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="feature-card-details">
                            <p>Saldo em Reais</p>
                            <h3>R$ {{ number_format(Auth::guard('client')->user()->balance, 2, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col col-sm-6 pb-15">
                    <div class="feature-card feature-card-blue">
                        <div class="feature-card-thumb">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="feature-card-details">
                            <p>Saldo em USDT</p>
                            <h3>$ {{ number_format(Auth::guard('client')->user()->balance_usdt, 2, '.', ',') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col col-sm-6 pb-15">
                    <div class="feature-card feature-card-violet">
                        <div class="feature-card-thumb">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="feature-card-details">
                            <p>Ultimo Recebimento</p>
                            @if ($last_value_received == [null])
                                <h3>R$ 0,00</h3>
                            @else
                                <h3>R$ {{ number_format($last_value_received['amount'], 2, ',', '.') }}</h3>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col col-sm-6 pb-15">
                    <div class="feature-card feature-card-green">
                        <div class="feature-card-thumb">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div class="feature-card-details">
                            <p>Ultimo valor enviado</p>
                            @if ($last_amount_sent == [null])
                                <h3>R$ 0,00</h3>
                            @else
                                <h3>R$ {{ number_format($last_amount_sent['amount'], 2, ',', '.') }}</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <!-- Transaction-section -->
            <div class="transaction-section pb-15">
                <div class="section-header">
                    <h2>Hoje</h2>
                </div>

                @foreach ($last_one_days as $item)

                    <div class="transaction-card mb-15">
                        @if($item['type_movement'] == 'CONVERSION')
                            <a href="{{ route('movement.get', ["$see_transaction_key" => $item['uuid']])}}">
                            <div class="transaction-card-info">
                                <div class="transaction-info-thumb">
                                    <img src="assets/images/horiizom/userbase.svg" alt="user">
                                </div>
                                <div class="transaction-info-text">
                                    <h3>CONVERSÃO</h3>
                                    <p>{!! $item['description'] !!}</p>
                                </div>
                            </div>
                            @if ($item['type'] == 'ENTRY')
                                <div class="transaction-card-det receive-money">
                                    + R$ {{ number_format($item['amount'], '2', ',', '.') }}
                                </div>
                            @else
                                <div class="transaction-card-det text-danger">
                                    - R$ {{ number_format($item['amount'], '2', ',', '.') }}
                                </div>
                            @endif
                        </a>
                        @else
                            <a href="{{ route('transaction.get', ["$see_transaction_key" => $item['uuid']])}}">
                                <div class="transaction-card-info">
                                    <div class="transaction-info-thumb">
                                        <img src="assets/images/horiizom/userbase.svg" alt="user">
                                    </div>
                                    <div class="transaction-info-text">
                                        @switch($item['type_movement'])
                                            @case('TRANSFER')
                                                <h3>TRANSFERÊNCIA</h3>
                                                @break

                                            @case('DEPOSIT')
                                                <h3>DEPÓSITO</h3>
                                                @break

                                            @case('WITHDRAWAL')
                                                <h3>SAQUE</h3>
                                                @break
                                            @case('CONVERSION')
                                                <h3>CONVERSÃO</h3>
                                                @break
                                        @endswitch
                                        <p>{!! $item['description'] !!}</p>
                                    </div>
                                </div>
                                @if ($item['type'] == 'ENTRY')
                                    <div class="transaction-card-det receive-money">
                                        + R$ {{ number_format($item['amount'], '2', ',', '.') }}
                                    </div>
                                @else
                                    <div class="transaction-card-det text-danger">
                                        - R$ {{ number_format($item['amount'], '2', ',', '.') }}
                                    </div>
                                @endif
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
            <!-- Transaction-section -->

            <!-- Transaction-section -->
            <div class="transaction-section pb">
                <div class="section-header">
                    <h2>7 dias</h2>
                </div>

                @foreach ($last_seven_days as $item)
                    @if($item['type_movement'] == 'CONVERSION')
                        <div class="transaction-card mb-15">
                            <a href="{{ route('movement.get', ["$see_transaction_key" => $item['uuid']]) }}">
                                <div class="transaction-card-info">
                                    <div class="transaction-info-thumb">
                                        <img src="assets/images/horiizom/userbase.svg" alt="user">
                                    </div>
                                    <div class="transaction-info-text">
                                        <h3>CONVERSÃO</h3>
                                        <p>{!! $item['description'] !!}</p>
                                    </div>
                                </div>
                                @if ($item['type'] == 'ENTRY')
                                    <div class="transaction-card-det receive-money">
                                        + R$ {{ number_format($item['amount'], '2', ',', '.') }}
                                    </div>
                                @else
                                    <div class="transaction-card-det text-danger">
                                        - R$ {{ number_format($item['amount'], '2', ',', '.') }}
                                    </div>
                                @endif
                            </a>
                        </div>
                    @else
                        <div class="transaction-card mb-15">
                            <a href="{{ route('transaction.get', ["$see_transaction_key" => $item['uuid']]) }}">
                                <div class="transaction-card-info">
                                    <div class="transaction-info-thumb">
                                        <img src="assets/images/horiizom/userbase.svg" alt="user">
                                    </div>
                                    <div class="transaction-info-text">
                                        @switch($item['type_movement'])
                                            @case('TRANSFER')
                                                <h3>TRANSFERÊNCIA</h3>
                                                @break

                                            @case('DEPOSIT')
                                                <h3>DEPÓSITO</h3>
                                                @break

                                            @case('WITHDRAWAL')
                                                <h3>SAQUE</h3>
                                                @break
                                        @endswitch
                                        <p>{!! $item['description'] !!}</p>
                                    </div>
                                </div>
                                @if ($item['type'] == 'ENTRY')
                                    <div class="transaction-card-det receive-money">
                                        + R$ {{ number_format($item['amount'], '2', ',', '.') }}
                                    </div>
                                @else
                                    <div class="transaction-card-det text-danger">
                                        - R$ {{ number_format($item['amount'], '2', ',', '.') }}
                                    </div>
                                @endif
                            </a>
                        </div>
                    @endif

                @endforeach
            </div>
            <!-- Transaction-section -->
        </div>
    </div>
    <!-- Body-content -->
@endsection
