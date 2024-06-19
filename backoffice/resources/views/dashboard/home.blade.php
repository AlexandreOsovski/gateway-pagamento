@extends('livewire.components.main')
@section('content')
    <div>
        <video playsinline autoplay muted loop id="bgvid">
            <source src="assets/video/bgone.mp4" type="video/mp4" />
        </video>
    </div>

    <div class="fixed-top">
        <div class="appbar-area sticky-black">
            <div class="container">
                <div class="appbar-container">
                    <div class="appbar-item appbar-actions">
                        <div class="appbar-action-item">
                            <a href="#" class="appbar-action-bar" data-bs-toggle="modal"
                                data-bs-target="#sidebarDrawer"><i class="color-fla flaticon-menu"></i></a>
                        </div>
                    </div>
                    <div class="appbar-item appbar-brand me-auto">
                        <a href="{{ route('dashboard.get') }}">
                            <img width="150px" src="assets/images/horiizom/logo.svg" alt="logo" class="main-logo">
                            <img width="150px" src="assets/images/horiizom/logo-hover.svg" alt="logo"
                                class="hover-logo">
                        </a>
                    </div>
                    <div class="appbar-item appbar-options">
                        <div class="appbar-option-item appbar-option-notification">
                            <a href="{{ route('notification.get') }}"><i class="flaticon-bell"></i></a>
                            @include('livewire.components.notification')
                        </div>
                        @php
                            if (empty(Auth::guard('client')->user()->avatar)) {
                                $avatar = 'assets/images/horiizom/newperfil.svg';
                            } else {
                                $avatar = Auth::guard('client')->user()->avatar;
                            }
                        @endphp
                        <div class="appbar-option-item appbar-option-profile">
                            <a href="{{ route('profile.get') }}"><img src="{{ $avatar }}" alt="profile"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Appbar -->

    <!-- Body-content -->
    <div class="body-content body-content-lg">
        <!-- "body-content-lg" add this class if any cards inside this div has "section-to-header" class -->
        <div class="container">
            <!-- Add-card -->
            <div class="add-card section-to-header mb-30">
                <div class="add-card-inner">
                    <livewire:see-balance />
                    <div class="add-card-item add-balance" data-bs-toggle="modal" data-bs-target="#addBalance">
                        <a href="#"><i class="flaticon-plus"></i></a>
                        <p>Depositar Saldo</p>
                    </div>
                </div>
            </div>
            <!-- Add-card -->
            <!-- Option-section -->
            <div class="option-section mb-15">
                <div class="row gx-3">
                    <div class="col pb-15">
                        <div class="option-card option-card-violet">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#withdraw">
                                <div class="option-card-icon" style="transform: rotate(180deg);">
                                    <i class="flaticon-down-arrow"></i>
                                </div>
                                <p>Transferir</p>
                            </a>
                        </div>
                    </div>
                    <div class="col pb-15">
                        <div class="option-card option-card-violet">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#sendMoney">
                                <div class="option-card-icon">
                                    <i class="flaticon-right-arrow"></i>
                                </div>
                                <p>P2P</p>
                            </a>
                        </div>
                    </div>
                    <div class="col pb-15">
                        <div class="option-card option-card-violet">
                            <a href="#">
                                <div class="option-card-icon">
                                    <i class="flaticon-credit-card"></i>
                                </div>
                                <p>Criar Link</p>
                            </a>
                        </div>
                    </div>
                    <div class="col pb-15">
                        <div class="option-card option-card-violet">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#exchange">
                                <div class="option-card-icon">
                                    <i class="flaticon-exchange-arrows"></i>
                                </div>
                                <p>Converter</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="feature-section mb-15">
                <div class="row gx-3">
                    <div class="col col-sm-6 pb-15">
                        <div class="feature-card feature-card-red">
                            <div class="feature-card-thumb">
                                <i class="fas fa-coins"></i>
                            </div>
                            <div class="feature-card-details">
                                <p>Saldo BRL</p>
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
                                <p>Saldo USDT</p>
                                <h3>$ {{ number_format(Auth::guard('client')->user()->balance_usdt, 2, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col col-sm-6 pb-15">
                        <div class="feature-card feature-card-violet">
                            <div class="feature-card-thumb">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <div class="feature-card-details">
                                <p>Ultimo Valor Recebido</p>
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
            <!-- Feature-section -->
            <!-- Transaction-section -->
            <div class="transaction-section pb-15">
                <div class="section-header">
                    <h2>Transações</h2>
                    <div class="view-all">
                        <a href="{{ route('finance.get') }}">Ver Todas</a>
                    </div>
                </div>
                {{-- <livewire:transactions /> --}}
                @if (empty($transactions))
                    <p>Nenhuma transação realizada</p>
                @endif

                @foreach ($transactions as $item)
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
                @endforeach
            </div>

            <div class="send-money-section pb-15">
                <div class="section-header">
                    <h2>Transferir Para</h2>
                    <div class="view-all">
                        <a href="#">Adicionar Novo</a>
                    </div>
                </div>
                <div class="row gx-3">
                    <p>Nenhum contato cadastrado</p>
                    {{-- <div class="col pb-15">
                        <div class="user-card">
                            <a href="#">
                                <div class="user-card-thumb">
                                    <img width="100" src="assets/images/horiizom/perfil12.svg" alt="user">
                                </div>
                                <h3>Brittany</h3>
                            </a>
                        </div>
                    </div> --}}
                </div>
            </div>

            <div class="saving-goals-section pb-15">
                <div class="section-header">
                    <h2>Minhas API's</h2>
                    <div class="view-all">
                        <a href="{{ route('keysapi.get') }}">Ver Todas</a>
                    </div>
                </div>
                @if (empty($keysApi))
                    <p>Nenhuma chave de API cadastrada</p>
                @endif
                @foreach ($keysApi as $item)
                    <div class="progress-card progress-card-red mb-15">
                        <div class="progress-card-info">
                            <div class="circular-progress" data-note="100">
                                <svg width="55" height="55" class="circle-svg">
                                    <circle cx="28" cy="27" r="25"
                                        class="circle-progress circle-progress-path">
                                    </circle>
                                    <circle cx="28" cy="27" r="25"
                                        class="circle-progress circle-progress-fill">
                                    </circle>
                                </svg>
                                <div class="percent">
                                    <i class="">API</i>
                                </div>
                            </div>
                            <div class="progress-info-text">
                                <h3>{{ $item['title'] }}</h3>
                                <p>{{ \Carbon\Carbon::parse($item['created_at'])->format('d/m/Y H:i') }}</p>
                                <p>API ID: {{ $item['appId'] }}</p>
                                <p>API KEY: {{ $item['appKey'] }}</p>
                            </div>

                        </div>
                        <div class="progress-card-amount color-green">Ativo</div>
                    </div>
                @endforeach
            </div>
            <!-- Saving-goals-section -->
            <!-- Latest-news-section -->

            <div class="latest-news-section pb-15">
                <div class="section-header">
                    <h2>Ultimas Notícias</h2>
                    <div class="view-all">
                        <a href="blogs.html">Ver Todas</a>
                    </div>
                </div>
                <div class="row gx-3">
                    <div class="col-6 pb-15">
                        <div class="blog-card">
                            <div class="blog-card-thumb">
                                <a href="#">
                                    <img src="assets/images/horiizom/notice1.png" alt="blog">
                                </a>
                            </div>
                            <div class="blog-card-details">
                                <ul class="blog-entry">
                                    <li>Globo Play</li>
                                    <li>15 Maio, 2024</li>
                                </ul>
                                <h3><a href="https://globoplay.globo.com/v/12642390/">Dropshipping: conheça as
                                        vantagens da técnica que exige baixo investimento e estoque.</a></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 pb-15">
                        <div class="blog-card">
                            <div class="blog-card-thumb">
                                <a href="#">
                                    <img src="assets/images/horiizom/notice2.png" alt="blog">
                                </a>
                            </div>
                            <div class="blog-card-details">
                                <ul class="blog-entry">
                                    <li>John Doe</li>
                                    <li>13 Jan, 2024</li>
                                </ul>
                                <h3><a
                                        href="https://economia.uol.com.br/cotacoes/noticias/redacao/2024/06/07/dolar-sobe-144-para-r-53247-com-dados-de-empregos-dos-eua.htm">Dólar
                                        sobe 1,44% em relação ao real brasileiro, atingindo o valor de R$ 5,3247, em
                                        reação aos dados de empregos dos Estados Unidos</a></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Latest-news-section -->
        </div>
    </div>
    <!-- Body-content -->


    @include('livewire.components.modals.addBalance')
    @include('livewire.components.modals.withdraws')
    @include('livewire.components.modals.sendMoney')
    @include('livewire.components.modals.exchange')
@endsection
