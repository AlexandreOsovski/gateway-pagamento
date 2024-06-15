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
                            <h3>R$10.000,00</h3>
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
                            <h3>$450.50</h3>
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
                            <h3>R$300.00</h3>
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
                            <h3>R$285.00</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <!-- Page-header -->
            <!-- <div class="page-header">
                                        <div class="page-header-title page-header-item">
                                            <h3>Minha Transações</h3>
                                        </div>
                                    </div> -->
            <!-- Page-header -->

            <!-- Transaction-section -->
            <div class="transaction-section pb-15">
                <div class="section-header">
                    <h2>Hoje</h2>
                </div>
                <div class="transaction-card mb-15">
                    <a href="transaction-details.html">
                        <div class="transaction-card-info">
                            <div class="transaction-info-thumb">
                                <img src="assets/images/horiizom/userbase.svg" alt="user">
                            </div>
                            <div class="transaction-info-text">
                                <h3>Venda de Produto</h3>
                                <p>Aprovado</p>
                            </div>
                        </div>
                        <div class="transaction-card-det receive-money">
                            + R$ 185.00
                        </div>
                    </a>
                </div>
                <div class="transaction-card mb-15">
                    <a href="transaction-details.html">
                        <div class="transaction-card-info">
                            <div class="transaction-info-thumb">
                                <img src="assets/images/horiizom/userbase.svg" alt="user">
                            </div>
                            <div class="transaction-info-text">
                                <h3>Venda de Produto</h3>
                                <p>Aprovado</p>
                            </div>
                        </div>
                        <div class="transaction-card-det receive-money">
                            + R$ 185.00
                        </div>
                    </a>
                </div>
            </div>
            <!-- Transaction-section -->

            <!-- Transaction-section -->
            <div class="transaction-section pb">
                <div class="section-header">
                    <h2>7 dias</h2>
                </div>
                <div class="transaction-card mb-15">
                    <a href="transaction-details.html">
                        <div class="transaction-card-info">
                            <div class="transaction-info-thumb">
                                <img src="assets/images/horiizom/userbase.svg" alt="user">
                            </div>
                            <div class="transaction-info-text">
                                <h3>Venda de Produto</h3>
                                <p>Aprovado</p>
                            </div>
                        </div>
                        <div class="transaction-card-det receive-money">
                            + R$ 185.00
                        </div>
                    </a>
                </div>
                <div class="transaction-card mb-15">
                    <a href="transaction-details.html">
                        <div class="transaction-card-info">
                            <div class="transaction-info-thumb">
                                <img src="assets/images/horiizom/userbase.svg" alt="user">
                            </div>
                            <div class="transaction-info-text">
                                <h3>Venda de Produto</h3>
                                <p>Aprovado</p>
                            </div>
                        </div>
                        <div class="transaction-card-det receive-money">
                            + R$ 185.00
                        </div>
                    </a>
                </div>
                <div class="transaction-card mb-15">
                    <a href="transaction-details.html">
                        <div class="transaction-card-info">
                            <div class="transaction-info-thumb">
                                <img src="assets/images/horiizom/userbase.svg" alt="user">
                            </div>
                            <div class="transaction-info-text">
                                <h3>Venda de Produto</h3>
                                <p>Aprovado</p>
                            </div>
                        </div>
                        <div class="transaction-card-det receive-money">
                            + R$ 185.00
                        </div>
                    </a>
                </div>
                <div class="transaction-card mb-15">
                    <a href="transaction-details.html">
                        <div class="transaction-card-info">
                            <div class="transaction-info-thumb">
                                <img src="assets/images/horiizom/userbase.svg" alt="user">
                            </div>
                            <div class="transaction-info-text">
                                <h3>Venda de Produto</h3>
                                <p>Aprovado</p>
                            </div>
                        </div>
                        <div class="transaction-card-det receive-money">
                            + R$ 185.00
                        </div>
                    </a>
                </div>
            </div>
            <!-- Transaction-section -->
        </div>
    </div>
    <!-- Body-content -->
@endsection
