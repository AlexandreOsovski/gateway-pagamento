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
                        <a href="{{ route('dashboard.get') }}" class="back-page"><i class="flaticon-left-arrow"></i></a>
                    </div>
                    <div class="appbar-action-item">
                        <a href="#" class="appbar-action-bar" data-bs-toggle="modal"
                            data-bs-target="#sidebarDrawer"><i class="flaticon-menu"></i></a>
                    </div>
                </div>
                <div class="appbar-item appbar-page-title">
                    <h3>@yield('title')</h3>
                </div>
                <div class="appbar-item appbar-options">
                    <div class="appbar-option-item appbar-option-notification">
                        <a href="notifications.html"><i class="flaticon-bell"></i></a>
                        <span class="option-badge">5</span>
                    </div>
                    <div class="appbar-option-item appbar-option-profile">
                        <a href="{{ route('profile.get') }}">
                            @php

                                if (empty(Auth::guard('client')->user()->avatar)) {
                                    $avatar = 'assets/images/horiizom/newperfil.svg';
                                } else {
                                    $avatar = Auth::guard('client')->user()->avatar;
                                }
                            @endphp
                            <img src="{{ $avatar }}" alt="profile">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Appbar -->
