<!-- Menu-modal -->
<div class="modal fade" id="sidebarDrawer" tabindex="-1" aria-labelledby="sidebarDrawer" aria-hidden="true">
    <div class="modal-dialog side-modal-dialog">
        <div class="modal-content">
            <div class="modal-header sidebar-modal-header">
                <div class="sidebar-profile-info">
                    <div class="sidebar-profile-thumb">

                        @php

                            if (empty(Auth::guard('client')->user()->avatar)) {
                                $avatar = 'assets/images/horiizom/newperfil.svg';
                            } else {
                                $avatar = Auth::guard('client')->user()->avatar;
                            }
                        @endphp

                        <img src="{{ $avatar }}" alt="profile">
                    </div>
                    <div class="sidebar-profile-text">
                        <h3>{{ Auth::guard('client')->user()->name }}</h3>
                        <p class="text-dark text-bold" style="font-size: 0.9em;">Codigo de usuario:
                        </p>
                        <p> {{ Auth::guard('client')->user()->uuid }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="sidebar-profile-wallet">
                <div class="add-card-info">
                    <p>Meu Saldo</p>
                    <h3>R$ {{ number_format(Auth::guard('client')->user()->balance, 2, ',', '.') }}</h3>
                </div>
            </div>
            <div class="modal-body">
                <div class="sidebar-nav">
                    <div class="sidebar-nav-item">
                        <h3>Menu</h3>
                        <ul class="sidebar-nav-list">
                            <li><a href="{{ route('dashboard.get') }}" class="active"><i class="fas fa-home"></i>
                                    Home</a></li>
                            <li><a href="{{ route('finance.get') }}"><i class="fas fa-file-invoice-dollar"></i>
                                    Financeiro</a></li>
                            {{-- <li><a href="#"><i class="fas fa-link"></i> Criar Link</a></li> --}}
                            {{-- <li><a href="perfil.html"><i class="fas fa-exchange-alt"></i> Converter</a></li> --}}
                            <li><a href="{{ route('profile.get') }}"><i class="fas fa-user-cog"></i> Meus Dados</a></li>
                            <li><a href="{{route('support.get')}}"><i class="fas fa-headset"></i> Suporte</a></li>
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
