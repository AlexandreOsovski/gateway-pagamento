<!DOCTYPE html>
<html lang="pt-br">

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
    @livewireStyles
</head>

<body>
    @if (Request::is('finance') || Request::is('profile') || Request::is('keys-api') || Request::is('notification'))
        @include('livewire.components.header')
    @endif
    @include('livewire.components.sidebar')
    @yield('content')
    @include('livewire.components.footer')
    @livewireScripts
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
