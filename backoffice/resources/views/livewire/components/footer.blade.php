@include('livewire.components.modals.withdraws')

<!-- Navbar -->
<div class="app-navbar">
    <div class="container">
        <div class="navbar-content ">
            <div class="navbar-content-item">
                <a href="{{ route('dashboard.get') }}" class="active">
                    <i class="flaticon-house"></i>
                    Home
                </a>
            </div>
            <div class="navbar-content-item">
                <a href="{{ route('finance.get') }}">
                    <i class="flaticon-invoice"></i>
                    Financeiro
                </a>
            </div>
            <div class="navbar-content-item">
                <a href="#" data-bs-toggle="modal" data-bs-target="#withdraw">
                    <i class="fas fa-paper-plane"></i>
                    Enviar PIX
                </a>
            </div>
            <div class="navbar-content-item">
                <a href="{{ route('keysapi.get') }}">
                    <i class="fas fa-cogs"></i>
                    API
                </a>
            </div>
            <div class="navbar-content-item">
                <a href="{{ route('profile.get') }}">
                    <i class="fas fa-user"></i>
                    Meus Dados
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Navbar -->
