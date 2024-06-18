<!DOCTYPE html>
<html lang="zxx">

<!-- Mirrored from templates.envytheme.com/oban/default/contact-us.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 08 Jun 2024 21:06:12 GMT -->

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
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-wrapper">
            <div class="preloader-content">
                <img src="assets/images/preloader-logo.png" alt="logo">
                <h3>Online Banking</h3>
            </div>
        </div>
    </div>
    <!-- Preloader -->

    <!-- Header-bg -->
    <div class="header-bg header-bg-1"></div>
    <!-- Header-bg -->

    <!-- Appbar -->
    <div class="fixed-top">
        <div class="appbar-area sticky-black">
            <div class="container">
                <div class="appbar-container">
                    <div class="appbar-item appbar-actions">
                        <div class="appbar-action-item">
                            <a href="#" class="back-page"><i class="flaticon-left-arrow"></i></a>
                        </div>
                        <div class="appbar-action-item">
                            <a href="#" class="appbar-action-bar" data-bs-toggle="modal"
                                data-bs-target="#sidebarDrawer"><i class="flaticon-menu"></i></a>
                        </div>
                    </div>
                    <div class="appbar-item appbar-page-title">
                        <h3>Contact Us</h3>
                    </div>
                    <div class="appbar-item appbar-options">
                        <div class="appbar-option-item appbar-option-notification">
                            <a href="{{ route('notification.get') }}"><i class="flaticon-bell"></i></a>
                            <span class="option-badge">5</span>
                        </div>
                        <div class="appbar-option-item appbar-option-profile">
                            <a href="perfil.html"><img src="assets/images/profile.jpg" alt="profile"></a>
                        </div>
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
                    <h3>Get In Touch</h3>
                </div>
            </div>
            <!-- Page-header -->

            <!-- Contact-us-section -->
            <div class="contact-us-section pb-15">
                <form class="contact-form pb-15" id="contactForm">
                    <div class="form-group mb-15">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required
                            data-error="Please enter your name" />
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group mb-15">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required
                            data-error="Please enter your email" />
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group mb-15">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" required
                            data-error="Please enter your contact number" />
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group mb-15">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control" required
                            data-error="Please enter your subject" />
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group mb-15">
                        <label class="form-label">Message</label>
                        <textarea name="message" class="form-control" id="message" rows="2"></textarea>
                    </div>
                    <button class="btn main-btn main-btn-lg full-width" type="submit">Send Message</button>
                    <div id="msgSubmit"></div>
                    <div class="clearfix"></div>
                </form>
                <div class="contact-info">
                    <p>6890 Blvd, The Bronx, NY 1058 New York, USA</p>
                    <p>+1 (514) 312-5678 or +1 (514) 312-6677</p>
                </div>
            </div>
            <!-- Contact-us-section -->
        </div>
    </div>
    <!-- Body-content -->

    <!-- Navbar -->
    <div class="app-navbar">
        <div class="container">
            <div class="navbar-content ">
                <div class="navbar-content-item">
                    <a href="home.html">
                        <i class="flaticon-house"></i>
                        Home
                    </a>
                </div>
                <div class="navbar-content-item">
                    <a href="pages.html" class="active">
                        <i class="flaticon-invoice"></i>
                        Pages
                    </a>
                </div>
                <div class="navbar-content-item">
                    <a href="components.html">
                        <i class="flaticon-menu-1"></i>
                        Components
                    </a>
                </div>
                <div class="navbar-content-item">
                    <a href="my-cards.html">
                        <i class="flaticon-credit-card"></i>
                        My Cards
                    </a>
                </div>
                <div class="navbar-content-item">
                    <a href="perfil.html">
                        <i class="flaticon-settings"></i>
                        Setting
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar -->

    <!-- Menu-modal -->
    <div class="modal fade" id="sidebarDrawer" tabindex="-1" aria-labelledby="sidebarDrawer" aria-hidden="true">
        <div class="modal-dialog side-modal-dialog">
            <div class="modal-content">
                <div class="modal-header sidebar-modal-header">
                    <div class="sidebar-profile-info">
                        <div class="sidebar-profile-thumb">
                            <img src="assets/images/profile.jpg" alt="profile">
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
                        <p>Your Wallet</p>
                        <h3>$1,450.50</h3>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="sidebar-nav">
                        <div class="sidebar-nav-item">
                            <h3>Oban Menu</h3>
                            <ul class="sidebar-nav-list">
                                <li><a href="home.html"><i class="flaticon-house"></i> Home</a></li>
                                <li><a href="pages.html"><i class="flaticon-invoice"></i> Pages</a></li>
                                <li><a href="components.html"><i class="flaticon-menu-1"></i> Components</a></li>
                                <li><a href="my-cards.html"><i class="flaticon-credit-card"></i> My Cards</a></li>
                                <li><a href="perfil.html"><i class="flaticon-settings"></i> Settings</a></li>
                                <li><a href="contact-us.html" class="active"><i
                                            class="flaticon-call-center-agent"></i> Contact Us</a></li>
                                <li><a href="#"><i class="flaticon-logout"></i> Logout</a></li>
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

<!-- Mirrored from templates.envytheme.com/oban/default/contact-us.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 08 Jun 2024 21:06:12 GMT -->

</html>
