<!DOCTYPE html>
<html lang="zxx">

<!-- Mirrored from templates.envytheme.com/oban/default/home.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 08 Jun 2024 21:04:40 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="description" content="Oban">
    <meta name="keywords" content="HTML,CSS,JavaScript">
    <meta name="author" content="HiBootstrap">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <title>Horiizon - Serviços de pagamento online.</title>
    <link rel="icon" href="assets/images/horiizom/favicon.svg" type="image/png" sizes="16x16">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- bootstrap css -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" media="all" />
    <!-- animate css -->
    <link rel="stylesheet" href="assets/css/animate.min.css" type="text/css" media="all" />
    <!-- owl carousel css -->
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css" type="text/css" media="all" />
    <!-- boxicons css -->
    <link rel='stylesheet' href='assets/css/icofont.min.css' type="text/css" media="all" />
    <!-- flaticon css -->
    <link rel='stylesheet' href='assets/css/flaticon.css' type="text/css" media="all" />
    <!-- style css -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all" />
    <!-- responsive css -->
    <link rel="stylesheet" href="assets/css/responsive.css" type="text/css" media="all" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/custom.css">
</head>

<body>
    <div>
        <video playsinline autoplay muted loop id="bgvid">
            <source src="assets/video/bgone.mp4" type="video/mp4" />
        </video>
    </div>

    <!-- Appbar -->
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
                        <a href="home.html">
                            <img width="150px" src="assets/images/horiizom/logo.svg" alt="logo" class="main-logo">
                            <img width="150px" src="assets/images/horiizom/logo-hover.svg" alt="logo"
                                class="hover-logo">
                        </a>
                    </div>
                    <div class="appbar-item appbar-options">
                        <div class="appbar-option-item appbar-option-notification">
                            <a href="notifications.html"><i class="flaticon-bell"></i></a>
                            <span style="color: white;" class="option-badge">5</span>
                        </div>
                        <div class="appbar-option-item appbar-option-profile">
                            <a href="perfil.html"><img src="assets/images/horiizom/newperfil.svg" alt="profile"></a>
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
                    <div class="add-card-item add-card-info">
                        <p>Meu Saldo</p>
                        <h3 class="color-theme">R$10,450.50</h3>
                    </div>
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
                                <div class="option-card-icon">
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
            <!-- Option-section -->
            <!-- Feature-section -->
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
            <!-- Feature-section -->
            <!-- Transaction-section -->
            <div class="transaction-section pb-15">
                <div class="section-header">
                    <h2>Transações</h2>
                    <div class="view-all">
                        <a href="financeiro.html">Ver Todas</a>
                    </div>
                </div>
                <div class="transaction-card mb-15">
                    <a href="transaction-details.html">
                        <div class="transaction-card-info">
                            <div class="transaction-info-thumb">
                                <img src="assets/images/horiizom/userbase.svg" alt="user">
                            </div>
                            <div class="transaction-info-text">
                                <h3>Usuario Master</h3>
                                <p>Transferência</p>
                            </div>
                        </div>
                        <div class="transaction-card-det negative-number">
                            - R$185.00
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
                                <h3>Venda de Produtos</h3>
                                <p>Aprovado</p>
                            </div>
                        </div>
                        <div class="transaction-card-det receive-money">
                            +R$159.99
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
                                <h3>Venda de Produtos</h3>
                                <p>Aprovado</p>
                            </div>
                        </div>
                        <div class="transaction-card-det receive-money">
                            +R$159.99
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
                                <h3>Compra de USDT</h3>
                                <p>Aprovado</p>
                            </div>
                        </div>
                        <div class="transaction-card-det negative-number">
                            -R$2.573,00
                        </div>
                    </a>
                </div>
            </div>

            <div class="send-money-section pb-15">
                <div class="section-header">
                    <h2>Transferir Para</h2>
                    <div class="view-all">
                        <a href="#">Adicionar Novo</a>
                    </div>
                </div>
                <div class="row gx-3">
                    <div class="col pb-15">
                        <div class="user-card">
                            <a href="#">
                                <div class="user-card-thumb">
                                    <img width="100" src="assets/images/horiizom/perfil12.svg" alt="user">
                                </div>
                                <h3>Brittany</h3>
                            </a>
                        </div>
                    </div>
                    <div class="col pb-15">
                        <div class="user-card">
                            <a href="#">
                                <div class="user-card-thumb">
                                    <img width="100" src="assets/images/horiizom/perfil12.svg" alt="user">
                                </div>
                                <h3>Jablonski</h3>
                            </a>
                        </div>
                    </div>
                    <div class="col pb-15">
                        <div class="user-card">
                            <a href="#">
                                <div class="user-card-thumb">
                                    <img width="100" src="assets/images/horiizom/perfil12.svg" alt="user">
                                </div>
                                <h3>Patricia</h3>
                            </a>
                        </div>
                    </div>
                    <div class="col pb-15">
                        <div class="user-card">
                            <a href="#">
                                <div class="user-card-thumb">
                                    <img width="100" src="assets/images/horiizom/perfil12.svg" alt="user">
                                </div>
                                <h3>Chancey</h3>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Transaction-section -->
            <!-- Monthly-bill-section -->
            <!-- <div class="monthly-bill-section pb-15">
                    <div class="section-header">
                        <h2>Monthly Bills</h2>
                        <div class="view-all">
                            <a href="monthly-bills.html">View All</a>
                        </div>
                    </div>
                    <div class="row gx-3">
                        <div class="col-6 pb-15">
                            <div class="monthly-bill-card monthly-bill-card-green">
                                <div class="monthly-bill-thumb">
                                    <img src="assets/images/cm-logo-1.png" alt="logo">
                                </div>
                                <div class="monthly-bill-body">
                                    <h3><a href="#">Envato.com</a></h3>
                                    <p>Debit Services Subscribtion</p>
                                </div>
                                <div class="monthly-bill-footer monthly-bill-action">
                                    <a href="#" class="btn main-btn">Pay Now</a>
                                    <p class="monthly-bill-price">$99.99</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 pb-15">
                            <div class="monthly-bill-card monthly-bill-card-green">
                                <div class="monthly-bill-thumb">
                                    <img src="assets/images/cm-logo-2.png" alt="logo">
                                </div>
                                <div class="monthly-bill-body">
                                    <h3><a href="#">Oban.com</a></h3>
                                    <p>Credit Services Subscribtion</p>
                                </div>
                                <div class="monthly-bill-footer monthly-bill-action">
                                    <a href="#" class="btn main-btn">Pay Now</a>
                                    <p class="monthly-bill-price">$75.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 pb-15">
                            <div class="monthly-bill-card monthly-bill-card-green">
                                <div class="monthly-bill-thumb">
                                    <img src="assets/images/cm-logo-3.png" alt="logo">
                                </div>
                                <div class="monthly-bill-body">
                                    <h3><a href="#">Nezox.com</a></h3>
                                    <p>Internet Monthly Subscribtion</p>
                                </div>
                                <div class="monthly-bill-footer monthly-bill-action">
                                    <a href="#" class="btn main-btn">Pay Now</a>
                                    <p class="monthly-bill-price">$50.50</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 pb-15">
                            <div class="monthly-bill-card monthly-bill-card-green">
                                <div class="monthly-bill-thumb">
                                    <img src="assets/images/cm-logo-4.png" alt="logo">
                                </div>
                                <div class="monthly-bill-body">
                                    <h3><a href="#">Depan.com</a></h3>
                                    <p>Depan Monthly Subscribtion</p>
                                </div>
                                <div class="monthly-bill-footer monthly-bill-action">
                                    <a href="#" class="btn main-btn">Pay Now</a>
                                    <p class="monthly-bill-price">$100.99</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            <!-- Monthly-bill-section -->
            <!-- Card-section -->
            <!-- <div class="card-section pb-15">
                    <div class="section-header">
                        <h2>My Cards</h2>
                        <div class="view-all">
                            <a href="my-cards.html">View All</a>
                        </div>
                    </div>
                    <div class="payment-image-card pb-15">
                        <img src="assets/images/card-1.png" alt="card">
                        <ul class="payment-uploaded-action">
                            <li>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#viewCard">
                                    <i class="icofont-ui-edit"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#deleteCard">
                                    <i class="flaticon-trash"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div> -->
            <!-- Card-section -->
            <!-- Send-money-section -->

            <!-- Send-money-section -->
            <!-- Saving-goals-section -->
            <div class="saving-goals-section pb-15">
                <div class="section-header">
                    <h2>Minhas API's</h2>
                    <div class="view-all">
                        <a href="my-savings.html">View All</a>
                    </div>
                </div>
                <div class="progress-card progress-card-red mb-15">
                    <div class="progress-card-info">
                        <div class="circular-progress" data-note="100">
                            <svg width="55" height="55" class="circle-svg">
                                <circle cx="28" cy="27" r="25"
                                    class="circle-progress circle-progress-path"></circle>
                                <circle cx="28" cy="27" r="25"
                                    class="circle-progress circle-progress-fill"></circle>
                            </svg>
                            <div class="percent">
                                <i class="">API</i>
                            </div>
                        </div>
                        <div class="progress-info-text">
                            <h3>Casino</h3>
                            <p>24/05/2000</p>
                            <p>API ID: 66652421840d7</p>
                            <p>API KEY: 13121321321b4345f4324d234d324bc</p>
                        </div>
                    </div>
                    <div class="progress-card-amount color-green">Ativa</div>
                </div>
                <div class="progress-card progress-card-red mb-15">
                    <div class="progress-card-info">
                        <div class="circular-progress" data-note="100">
                            <svg width="55" height="55" class="circle-svg">
                                <circle cx="28" cy="27" r="25"
                                    class="circle-progress circle-progress-path"></circle>
                                <circle cx="28" cy="27" r="25"
                                    class="circle-progress circle-progress-fill"></circle>
                            </svg>
                            <div class="percent">
                                <i class="">API</i>
                            </div>
                        </div>
                        <div class="progress-info-text">
                            <h3>Shopify</h3>
                            <p>24/05/2000</p>
                            <p>API ID: 66652421840d7</p>
                            <p>API KEY: 13121321321b4345f4324d234d324bc</p>
                        </div>
                    </div>
                    <div class="progress-card-amount color-green">Ativa</div>
                </div>
                <div class="progress-card progress-card-red mb-15">
                    <div class="progress-card-info">
                        <div class="circular-progress" data-note="100">
                            <svg width="55" height="55" class="circle-svg">
                                <circle cx="28" cy="27" r="25"
                                    class="circle-progress circle-progress-path"></circle>
                                <circle cx="28" cy="27" r="25"
                                    class="circle-progress circle-progress-fill"></circle>
                            </svg>
                            <div class="percent">
                                <i class="">API</i>
                            </div>
                        </div>
                        <div class="progress-info-text">
                            <h3>Vega Checkout</h3>
                            <p>24/05/2000</p>
                            <p>API ID: 66652421840d7</p>
                            <p>API KEY: 13121321321b4345f4324d234d324bc</p>
                        </div>
                    </div>
                    <div class="progress-card-amount color-green">Ativa</div>
                </div>
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

    <!-- Footer -->
    <footer class="footer-bg">
        <div class="container">
            <p>Todos os seus direitos reservados <a href="#" target="_blank"><span
                        style="color: white;">HORIIZOM</span></a></p>
        </div>
    </footer>
    <!-- Footer -->

    <!-- Navbar -->
    <div class="app-navbar">
        <div class="container">
            <div class="navbar-content ">
                <div class="navbar-content-item">
                    <a href="home.html" class="active">
                        <i class="flaticon-house"></i>
                        Home
                    </a>
                </div>
                <div class="navbar-content-item">
                    <a href="financeiro.html">
                        <i class="flaticon-invoice"></i>
                        Financeiro
                    </a>
                </div>
                <div class="navbar-content-item">
                    <a href="#">
                        <i class="fas fa-paper-plane"></i>
                        Enviar PIX
                    </a>
                </div>
                <div class="navbar-content-item">
                    <a href="api.html">
                        <i class="fas fa-cogs"></i>
                        API
                    </a>
                </div>
                <div class="navbar-content-item">
                    <a href="perfil.html">
                        <i class="fas fa-user"></i>
                        Meus Dados
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar -->

    <!-- Add-balance-modal -->
    <div class="modal fade" id="addBalance" tabindex="-1" aria-labelledby="addBalance" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="container">
                    <div class="modal-header">
                        <div class="modal-header-title">
                            <h5 class="modal-title">Depositar</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group mb-15">
                                <label for="input1" class="form-label">Total a Depositar</label>
                                <input type="number" class="form-control" id="input1"
                                    placeholder="Digite a quantidade a Depositar">
                            </div>
                            <button type="submit" class="btn main-btn main-btn-lg full-width">Gerar Deposito</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add-balance-modal -->

    <!-- Withdraw-modal -->
    <div class="modal fade" id="withdraw" tabindex="-1" aria-labelledby="withdraw" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="container">
                    <div class="modal-header">
                        <div class="modal-header-title">
                            <i class="flaticon-down-arrow color-blue"></i>
                            <h5 class="modal-title"> Transferir</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group mb-15">
                                <label for="input3" class="form-label">Chave Pix</label>
                                <input type="email" class="form-control" id="input3"
                                    placeholder="Digite a chave PIX">
                            </div>
                            <div class="form-group mb-15">
                                <label for="input5" class="form-label">Valor a Transferir</label>
                                <input type="email" class="form-control" id="input5"
                                    placeholder="Digite o valor a ser enviado.">
                            </div>
                            <div class="form-group mb-15">
                                <label for="input4" class="form-label">Codigo 2FA</label>
                                <input type="email" class="form-control" id="input4"
                                    placeholder="Digite o codigo enviado ao seu email.">
                            </div>
                            <button type="submit" class="btn main-btn main-btn-lg full-width">Transferir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Withdraw-modal -->

    <!-- Send-money-modal -->
    <div class="modal fade" id="sendMoney" tabindex="-1" aria-labelledby="sendMoney" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="container">
                    <div class="modal-header">
                        <div class="modal-header-title">

                            <h5 class="modal-title">P2P</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group mb-15">
                                <label for="input6" class="form-label">Email ou Codigo de Usuário</label>
                                <input type="email" class="form-control" id="input6"
                                    placeholder="Digite o Email ou Codigo de Usuário">
                            </div>
                            <div class="form-group mb-15">
                                <label for="input5" class="form-label">Valor a Transferir</label>
                                <input type="email" class="form-control" id="input5"
                                    placeholder="Digite o valor a ser enviado.">
                            </div>
                            <div class="form-group mb-15">
                                <label for="input4" class="form-label">Codigo 2FA</label>
                                <input type="email" class="form-control" id="input4"
                                    placeholder="Digite o codigo enviado ao seu email.">
                            </div>
                            <button type="submit" class="btn main-btn main-btn-lg full-width">Transferir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Send-money-modal -->

    <!-- Exchange-modal -->
    <div class="modal fade" id="exchange" tabindex="-1" aria-labelledby="exchange" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="container">
                    <div class="modal-header">
                        <div class="modal-header-title">
                            <h5 class="modal-title">Converter</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group mb-15">
                                <label for="input9" class="form-label">Valor em Reais</label>
                                <input type="email" class="form-control" id="input9" placeholder="BRL">
                            </div>
                            <div class="form-group mb-15">
                                <label for="input10" class="form-label">Valor em USDT</label>
                                <input type="email" class="form-control" id="input10" placeholder="USDT">
                            </div>
                            <div class="form-group mb-15">
                                <label for="input4" class="form-label">Codigo 2FA</label>
                                <input type="email" class="form-control" id="input4"
                                    placeholder="Digite o codigo enviado ao seu email.">
                            </div>
                            <button type="submit" class="btn main-btn main-btn-lg full-width">Converter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Exchange-modal -->

    <!-- AddCard-modal -->
    <div class="modal fade" id="addCard" tabindex="-1" aria-labelledby="addCard" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="container">
                    <div class="modal-header">
                        <div class="modal-header-title">
                            <h5 class="modal-title">Add A New Card</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group mb-15">
                                <div class="form-card-upload">
                                    <label class="card-upload-thumb" for="uploadCard">
                                        <i class="flaticon-camera"></i>
                                    </label>
                                    <input type="file" id="uploadCard" class="d-none">
                                </div>
                            </div>
                            <div class="form-group mb-15">
                                <label class="form-label">Card Type</label>
                                <input type="email" class="form-control" placeholder="Mastercard">
                            </div>
                            <div class="form-group mb-15">
                                <label class="form-label">Card Number</label>
                                <input type="email" class="form-control" placeholder="****  ****  ****  ****">
                            </div>
                            <div class="form-group mb-15 overflow-hidden">
                                <div class="row gx-2">
                                    <div class="col-6">
                                        <label class="form-label">Expiry Date</label>
                                        <div class="row gx-2">
                                            <div class="col-6">
                                                <select class="form-control">
                                                    <option value="1">01</option>
                                                    <option value="2">02</option>
                                                    <option value="3">03</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <select class="form-control">
                                                    <option value="1">01</option>
                                                    <option value="2">02</option>
                                                    <option value="3">03</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">CVV</label>
                                        <input type="email" class="form-control" placeholder="453">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn main-btn full-width">Add Card</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- AddCard-modal -->

    <!-- View-card-modal -->
    <div class="modal fade" id="viewCard" tabindex="-1" aria-labelledby="viewCard" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="container">
                    <div class="modal-header">
                        <div class="modal-header-title">
                            <h5 class="modal-title">Edit Card</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group mb-15">
                                <div class="form-card-uploaded">
                                    <!-- "form-card-uploaded" class is used for already uploaded card. -->
                                    <img src="assets/images/card-1.png" alt="card">
                                    <label class="form-card-uploaded-edit" for="editUploadCard">
                                        <i class="flaticon-camera"></i>
                                    </label>
                                    <input type="file" id="editUploadCard" class="d-none">
                                </div>
                            </div>
                            <div class="form-group mb-15">
                                <label class="form-label">Card Type</label>
                                <input type="email" class="form-control" placeholder="Mastercard"
                                    value="Credit Card">
                            </div>
                            <div class="form-group mb-15">
                                <label class="form-label">Card Number</label>
                                <input type="email" class="form-control" placeholder="****  ****  ****  ****"
                                    value="0123 4567 8901 2345">
                            </div>
                            <div class="form-group mb-15 overflow-hidden">
                                <div class="row gx-2">
                                    <div class="col-6">
                                        <label class="form-label">Expiry Date</label>
                                        <div class="row gx-2">
                                            <div class="col-6">
                                                <select class="form-control">
                                                    <option value="1">01</option>
                                                    <option value="2">02</option>
                                                    <option value="3">03</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <select class="form-control">
                                                    <option value="1">01</option>
                                                    <option value="2">02</option>
                                                    <option value="3">03</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">CVV</label>
                                        <input type="email" class="form-control" placeholder="453" value="3334">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn main-btn full-width">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- View-card-modal -->

    <!-- Delete-card-modal -->
    <div class="modal fade" id="deleteCard" tabindex="-1" aria-labelledby="deleteCard" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-animatezoom">
            <div class="modal-content">
                <div class="container">
                    <div class="modal-header">
                        <div class="modal-header-title">
                            <h5 class="modal-title">Delete Card</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body modal-body-center">
                        <form class="text-center">
                            <h3>Are You Sure You Want To Delete This Card?</h3>
                            <button type="submit"
                                class="btn main-btn main-btn-red main-btn-lg full-width">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete-card-modal -->

    <!-- Menu-modal -->
    <div class="modal fade" id="sidebarDrawer" tabindex="-1" aria-labelledby="sidebarDrawer" aria-hidden="true">
        <div class="modal-dialog side-modal-dialog">
            <div class="modal-content">
                <div class="modal-header sidebar-modal-header">
                    <div class="sidebar-profile-info">
                        <div class="sidebar-profile-thumb">
                            <img src="assets/images/horiizom/newperfil.svg" alt="profile">
                        </div>
                        <div class="sidebar-profile-text">
                            <h3>Usuario Master</h3>
                            <p>Codigo de usuario: HRM1023</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="sidebar-profile-wallet">
                    <div class="add-card-info">
                        <p>Meu Saldo</p>
                        <h3>R$10,450.50</h3>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="sidebar-nav">
                        <div class="sidebar-nav-item">
                            <h3>Menu</h3>
                            <ul class="sidebar-nav-list">
                                <li><a href="home.html" class="active"><i class="fas fa-home"></i> Home</a></li>
                                <li><a href="financeiro.html"><i class="fas fa-file-invoice-dollar"></i>
                                        Financeiro</a></li>
                                <li><a href="components.html"><i class="fas fa-chevron-down"></i> Transferir</a></li>
                                <li><a href="#"><i class="fas fa-link"></i> Criar Link</a></li>
                                <li><a href="perfil.html"><i class="fas fa-exchange-alt"></i> Converter</a></li>
                                <li><a href="perfil.html"><i class="fas fa-user-cog"></i> Meus Dados</a></li>
                                <li><a href="contact-us.html"><i class="fas fa-headset"></i> Suporte</a></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            style="margin-left: 10px; background: transparent; color: #7d4eff; "><i
                                                class="fas fa-sign-out-alt"></i> Sair</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Menu-modal -->

    <!-- Scroll-top -->
    <div class="scroll-top" id="scrolltop">
        <div class="scroll-top-inner">
            <i class="icofont-long-arrow-up"></i>
        </div>
    </div>
    <!-- Scroll-top -->


    <!-- essential js -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!-- owl carousel js -->
    <script src="assets/js/owl.carousel.min.js"></script>
    <!-- form ajazchimp js -->
    <script src="assets/js/jquery.ajaxchimp.min.js"></script>
    <!-- form validator js  -->
    <script src="assets/js/form-validator.min.js"></script>
    <!-- contact form js -->
    <script src="assets/js/contact-form-script.js"></script>
    <!-- main js -->
    <script src="assets/js/script.js"></script>
</body>

<!-- Mirrored from templates.envytheme.com/oban/default/home.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 08 Jun 2024 21:05:23 GMT -->

</html>
