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
                            <input id="email" type="email" name="email" class="form-control" required
                                placeholder="Digite seu Email">
                            <span class="input-group-text"><i class="flaticon-user-picture"></i></span>
                        </div>
                    </div>
                    <div class="form-group pb-15">
                        <label>Senha</label>
                        <div class="input-group">
                            <input id="senha" type="password" name="password" class="form-control password" required
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
                    <button type="submit" id="btn-text"
                        class="btn color-white main-btn main-btn-lg btn-send full-width mb-10">
                        <span style="font-size: 15px;">Entrar</span>
                    </button>

                    <div id="spinner" class="btn color-white main-btn main-btn-lg btn-send full-width mb-10">
                        <span style="font-size: 15px;">
                            <svg style="width: 22px" version="1.1" id="L7"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100"
                                xml:space="preserve">
                                <path fill="#fff" d="M31.6,3.5C5.9,13.6-6.6,42.7,3.5,68.4c10.1,25.7,39.2,38.3,64.9,28.1l-3.1-7.9c-21.3,8.4-45.4-2-53.8-23.3
                                                        c-8.4-21.3,2-45.4,23.3-53.8L31.6,3.5z">
                                    <animateTransform attributeName="transform" attributeType="XML" type="rotate"
                                        dur="2s" from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                                </path>
                                <path fill="#fff" d="M42.3,39.6c5.7-4.3,13.9-3.1,18.1,2.7c4.3,5.7,3.1,13.9-2.7,18.1l4.1,5.5c8.8-6.5,10.6-19,4.1-27.7
                                                        c-6.5-8.8-19-10.6-27.7-4.1L42.3,39.6z">
                                    <animateTransform attributeName="transform" attributeType="XML" type="rotate"
                                        dur="1s" from="0 50 50" to="-360 50 50" repeatCount="indefinite" />
                                </path>
                                <path fill="#fff" d="M82,35.7C74.1,18,53.4,10.1,35.7,18S10.1,46.6,18,64.3l7.6-3.4c-6-13.5,0-29.3,13.5-35.3s29.3,0,35.3,13.5
                                                        L82,35.7z">
                                    <animateTransform attributeName="transform" attributeType="XML" type="rotate"
                                        dur="2s" from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                                </path>
                            </svg>
                        </span>
                    </div>


                </form>
                <div class="form-desc">Não tem uma conta? <a href="{{ route('register.get') }}">Cadastra-se!</a></div>
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
        <div class="modal-dialog modal-dialog-centered modal-sm modal-recovery-pass">
            <div class="modal-content">
                <div class="container">
                    <div class="modal-header">
                        <div class="modal-header-title">
                            <h5 class="modal-title">Esqueceu a senha?</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body modal-body-center">
                        <h3>Digite o e-mail cadastrado<br /> na plataforma</h3>
                        <div class="reset-form">
                            <form action="{{ route('send-code.post') }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="input-group">
                                    <input type="text" name="email_recovery" placeholder="Seu E-mail...." />
                                </div>
                                <button type="submit" id="btn-text-forgot-password"
                                    class="btn-text-forgot-password btn main-btn main-btn-lg full-width">Alterar
                                    Senha</button>

                                <div id="spinner-forgot-password"
                                    class="btn color-white main-btn main-btn-lg btn-send full-width mb-10">
                                    <span style="font-size: 15px;">
                                        <svg style="width: 22px" version="1.1" id="L7"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 100 100" enable-background="new 0 0 100 100"
                                            xml:space="preserve">
                                            <path fill="#fff" d="M31.6,3.5C5.9,13.6-6.6,42.7,3.5,68.4c10.1,25.7,39.2,38.3,64.9,28.1l-3.1-7.9c-21.3,8.4-45.4-2-53.8-23.3
                                                                    c-8.4-21.3,2-45.4,23.3-53.8L31.6,3.5z">
                                                <animateTransform attributeName="transform" attributeType="XML"
                                                    type="rotate" dur="2s" from="0 50 50" to="360 50 50"
                                                    repeatCount="indefinite" />
                                            </path>
                                            <path fill="#fff" d="M42.3,39.6c5.7-4.3,13.9-3.1,18.1,2.7c4.3,5.7,3.1,13.9-2.7,18.1l4.1,5.5c8.8-6.5,10.6-19,4.1-27.7
                                                                    c-6.5-8.8-19-10.6-27.7-4.1L42.3,39.6z">
                                                <animateTransform attributeName="transform" attributeType="XML"
                                                    type="rotate" dur="1s" from="0 50 50" to="-360 50 50"
                                                    repeatCount="indefinite" />
                                            </path>
                                            <path fill="#fff" d="M82,35.7C74.1,18,53.4,10.1,35.7,18S10.1,46.6,18,64.3l7.6-3.4c-6-13.5,0-29.3,13.5-35.3s29.3,0,35.3,13.5
                                                                    L82,35.7z">
                                                <animateTransform attributeName="transform" attributeType="XML"
                                                    type="rotate" dur="2s" from="0 50 50" to="360 50 50"
                                                    repeatCount="indefinite" />
                                            </path>
                                        </svg>
                                    </span>
                                </div>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $('#spinner').hide();
        $(document).ready(function() {
            $('.btn-send').click(function() {
                $('#spinner').prop('disabled', true).show();
                $('#btn-text').hide();
            });
        });
    </script>
    <script>
        $('#spinner-forgot-password').hide();
        $(document).ready(function() {
            $('.btn-send').click(function() {
                $('#spinner-forgot-password').prop('disabled', true).show();
                $('#btn-text-forgot-password').hide();
            });
        });
    </script>

</body>

<!-- Mirrored from templates.envytheme.com/oban/default/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 08 Jun 2024 21:06:13 GMT -->

</html>
