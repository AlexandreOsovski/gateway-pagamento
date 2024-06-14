<!DOCTYPE html>
<html lang="zxx" class="position-relative">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Oban">
    <meta name="keywords" content="HTML,CSS,JavaScript">
    <meta name="author" content="HiBootstrap">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <title>Horiizon - Serviços de pagamento online.</title>
    <link rel="icon" href="assets/images/horiizom/favicon.svg" type="image/png" sizes="16x16">

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
                            <a href="#" class="back-page"><i class="flaticon-left-arrow"></i></a>
                        </div>
                    </div>
                    <div class="appbar-item appbar-page-title mx-auto">
                        <h3>Acessar Conta</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Appbar -->

    <!-- Body-content -->
    <div class="body-content">
        <div class="container">
            <!-- Page-header -->
            <div class="page-header">
                <div class="page-header-title page-header-item">
                    <h3>Acesse sua conta!</h3>
                </div>
            </div>
            <!-- Page-header -->

            <!-- Authentication-section -->
            <div class="authentication-form pb-15">
                <form action="{{ route('login.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group pb-15">
                        <label>Email</label>
                        <div class="input-group">
                            <input type="email" name="email" class="form-control" required
                                placeholder="Digite seu Email">
                            <span class="input-group-text"><i class="flaticon-user-picture"></i></span>
                        </div>
                    </div>
                    <div class="form-group pb-15">
                        <label>Senha</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control password" required
                                placeholder="**********">
                            <span class="input-group-text reveal">
                                <i class="flaticon-invisible pass-close"></i>
                                <i class="flaticon-visibility pass-view"></i>
                            </span>
                        </div>
                    </div>
                    <div class="authentication-account-access pb-15">
                        <div class="authentication-account-access-item">
                            <div class="input-checkbox">
                                <input type="checkbox" id="check1">
                                <label for="check1">Lembrar de mim</label>
                            </div>
                        </div>
                        <div class="authentication-account-access-item">
                            <div class="authentication-link">
                                <a href="forget-password.html" data-bs-toggle="modal"
                                    data-bs-target="#resetPassword">Esqueceu sua Senha?</a>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="btn color-white main-btn main-btn-lg full-width mb-10">Entrar</button>
                </form>
                <div class="form-desc">Não tem uma conta? <a href="registro.html">Cadastra-se!</a></div>
            </div>
            <!-- Authentication-section -->
        </div>
    </div>
    <!-- Body-content -->

    <!-- footer -->
    <footer class="fixed-footer">
        <div class="container">
            <p>Todos os seus direitos reservados <a href="#" target="_blank">horiizom</a></p>
        </div>
    </footer>
    <!-- .end footer -->

    <!-- ResetPassword -->
    <div class="modal fade" id="resetPassword" tabindex="-1" aria-labelledby="resetPassword" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="container">
                    <div class="modal-header">
                        <div class="modal-header-title">
                            <h5 class="modal-title">Forget Password</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body modal-body-center">
                        <h3>Type Your Email To Reset Your Password</h3>
                        <div class="reset-form">
                            <form>
                                <div class="input-group">
                                    <input type="text" placeholder="Your Email Address" />
                                </div>
                                <button type="submit" class="btn main-btn main-btn-lg full-width">Reset
                                    Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ResetPassword -->

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

<!-- Mirrored from templates.envytheme.com/oban/default/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 08 Jun 2024 21:06:13 GMT -->

</html>
