@extends('livewire.components.main')
@section('title', 'Meu Perfil')
@section('content')
    <!-- Body-content -->
    <div class="body-content">
        <div class="container">
            <!-- Setting -->
            <div class="setting-section pb-15">
                <div class="user-setting-thumb">
                    <div class="user-setting-thumb-up">
                        @php

                            if (empty(Auth::guard('client')->user()->avatar)) {
                                $avatar = asset('assets/images/horiizom/newperfil.svg');
                            } else {
                                $avatar = asset('storage/' . Auth::guard('client')->user()->avatar);
                            }
                        @endphp
                        <img id="previewImage" src="{{ $avatar }}" alt="profile">
                    </div>
                    <label for="upThumb">
                        <i class="flaticon-camera"></i>
                    </label>
                    <form id="imageUploadForm" action="{{ route('alterdata.put') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="file" id="upThumb" name="avatar" class="d-none" accept="image/*">
                    </form>

                </div>
                <!-- Setting-list -->
                <div class="setting-list">
                    <ul>
                        <!-- <li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#userName">Mudar Nome</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </li> -->
                        <li>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#emailModal">Alterar Email</a>
                        </li>
                        <li>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#userName">Alterar Nome</a>
                        </li>
                        <li>
                            {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#birthdayModal">Nascimento</a> --}}
                        </li>
                        <li>
                            {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#languageModal">Linguagem</a> --}}
                        </li>
                        <li>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#passwordModal">Alterar Senha</a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    style="
                                        background-color: transparent;
                                        font-size: 15px;
                                        color: #7d4eff !important;
                                        padding: 14px;
                                        margin-top: 0px;
                                        margin-bottom: -4px;
                                        margin-left: -13px;
                                    ">Sair</button>
                            </form>
                        </li>
                    </ul>
                </div>
                <!-- Setting-list -->
            </div>
            <!-- Setting -->
        </div>
    </div>
    <!-- Body-content -->


    <!-- Username-modal -->
    <div class="modal fade" id="userName" tabindex="-1" aria-labelledby="userName" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="container">
                    <div class="modal-header">
                        <div class="modal-header-title">
                            <h5 class="modal-title">Alterar Nome</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('alterdata.put') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-15">
                                <label class="form-label">Digite o nome</label>
                                <input type="text" class="form-control" name="name" placeholder="Digite o nome..."
                                    value="{{ Auth::guard('client')->user()->name }}">
                            </div>
                            <button type="submit" id="btn-text-name"
                                class="btn btn-send-name main-btn main-btn-lg full-width">Alterar
                                Nome</button>

                            <div id="spinner-name" class="btn color-white main-btn main-btn-lg btn-send full-width mb-10">
                                <span style="font-size: 15px;">
                                    <svg style="width: 22px" version="1.1" id="L7"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100"
                                        xml:space="preserve">
                                        <path fill="#fff"
                                            d="M31.6,3.5C5.9,13.6-6.6,42.7,3.5,68.4c10.1,25.7,39.2,38.3,64.9,28.1l-3.1-7.9c-21.3,8.4-45.4-2-53.8-23.3
                                                                                                                                                                                                                                                                                                                                                                                            c-8.4-21.3,2-45.4,23.3-53.8L31.6,3.5z">
                                            <animateTransform attributeName="transform" attributeType="XML" type="rotate"
                                                dur="2s" from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                                        </path>
                                        <path fill="#fff"
                                            d="M42.3,39.6c5.7-4.3,13.9-3.1,18.1,2.7c4.3,5.7,3.1,13.9-2.7,18.1l4.1,5.5c8.8-6.5,10.6-19,4.1-27.7
                                                                                                                                                                                                                                                                                                                                                                                            c-6.5-8.8-19-10.6-27.7-4.1L42.3,39.6z">
                                            <animateTransform attributeName="transform" attributeType="XML" type="rotate"
                                                dur="1s" from="0 50 50" to="-360 50 50" repeatCount="indefinite" />
                                        </path>
                                        <path fill="#fff"
                                            d="M82,35.7C74.1,18,53.4,10.1,35.7,18S10.1,46.6,18,64.3l7.6-3.4c-6-13.5,0-29.3,13.5-35.3s29.3,0,35.3,13.5
                                                                                                                                                                                                                                                                                                                                                                                            L82,35.7z">
                                            <animateTransform attributeName="transform" attributeType="XML" type="rotate"
                                                dur="2s" from="0 50 50" to="360 50 50" repeatCount="indefinite" />
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
    <!-- Username-modal -->

    <!-- Email-modal -->
    <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="container">
                    <div class="modal-header">
                        <div class="modal-header-title">
                            <h5 class="modal-title">Alterar E-mail</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="emailForm" action="{{ route('alterdata.put') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-15">
                                <label class="form-label">Digite o novo e-mail</label>
                                <input type="text" class="form-control" name="email"
                                    value="{{ Auth::guard('client')->user()->email }}">
                            </div>
                            <button type="submit" id="btn-text-email"
                                class="btn btn-send-email main-btn main-btn-lg full-width">Alterar e-mail</button>

                            <div id="spinner-email"
                                class="btn color-white main-btn main-btn-lg btn-send full-width mb-10">
                                <span style="font-size: 15px;">
                                    <svg style="width: 22px" version="1.1" id="L7"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100"
                                        xml:space="preserve">
                                        <path fill="#fff"
                                            d="M31.6,3.5C5.9,13.6-6.6,42.7,3.5,68.4c10.1,25.7,39.2,38.3,64.9,28.1l-3.1-7.9c-21.3,8.4-45.4-2-53.8-23.3
                                                                                                                                                                                                                                                                                c-8.4-21.3,2-45.4,23.3-53.8L31.6,3.5z">
                                            <animateTransform attributeName="transform" attributeType="XML"
                                                type="rotate" dur="2s" from="0 50 50" to="360 50 50"
                                                repeatCount="indefinite" />
                                        </path>
                                        <path fill="#fff"
                                            d="M42.3,39.6c5.7-4.3,13.9-3.1,18.1,2.7c4.3,5.7,3.1,13.9-2.7,18.1l4.1,5.5c8.8-6.5,10.6-19,4.1-27.7
                                                                                                                                                                                                                                                                                c-6.5-8.8-19-10.6-27.7-4.1L42.3,39.6z">
                                            <animateTransform attributeName="transform" attributeType="XML"
                                                type="rotate" dur="1s" from="0 50 50" to="-360 50 50"
                                                repeatCount="indefinite" />
                                        </path>
                                        <path fill="#fff"
                                            d="M82,35.7C74.1,18,53.4,10.1,35.7,18S10.1,46.6,18,64.3l7.6-3.4c-6-13.5,0-29.3,13.5-35.3s29.3,0,35.3,13.5
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
    <!-- Email-modal -->

    <!-- Address-modal -->
    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="container">
                    <div class="modal-header">
                        <div class="modal-header-title">
                            <h5 class="modal-title">Endereço</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group mb-15">
                                <label class="form-label">Endereço</label>
                                <input type="text" class="form-control"
                                    placeholder="Rua exemplo, bairro exemplo, cidade exemplo.">
                            </div>
                            <button type="submit" class="btn main-btn main-btn-lg full-width"> Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Address-modal -->

    <!-- Birthday-modal -->
    <div class="modal fade" id="birthdayModal" tabindex="-1" aria-labelledby="birthdayModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="container">
                    <div class="modal-header">
                        <div class="modal-header-title">
                            <h5 class="modal-title">Data de nascimento</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group mb-15">
                                <label class="form-label">Data de nascimento</label>
                                <input type="date" class="form-control">
                            </div>
                            <button type="submit" class="btn main-btn main-btn-lg full-width">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Birthday-modal -->


    <!-- Password-modal -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="container">
                    <div class="modal-header">
                        <div class="modal-header-title">
                            <h5 class="modal-title">Alterar Senha</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="passwordForm" action="{{ route('alterdata.put') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group pb-15">
                                <label>Atual Senha</label>
                                <div class="input-group">
                                    <input type="password" name="old_password" class="form-control password" required
                                        placeholder="**********">
                                    <span class="input-group-text reveal">
                                        <i class="flaticon-invisible pass-close"></i>
                                        <i class="flaticon-visibility pass-view"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group pb-15">
                                <label>Nova Senha</label>
                                <div class="input-group">
                                    <input type="password" name="new_password" id="new_password"
                                        class="form-control password" required placeholder="**********">
                                    <span class="input-group-text reveal">
                                        <i class="flaticon-invisible pass-close"></i>
                                        <i class="flaticon-visibility pass-view"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group pb-15">
                                <label>Confirmar Senha</label>
                                <div class="input-group">
                                    <input type="password" name="confirm_password" id="confirm_password"
                                        class="form-control password" required placeholder="**********">
                                    <span class="input-group-text reveal">
                                        <i class="flaticon-invisible pass-close"></i>
                                        <i class="flaticon-visibility pass-view"></i>
                                    </span>
                                </div>

                                <div id="passwordMismatch" class="alert alert-danger d-none mt-2">
                                    As senhas não coincidem. Por favor, verifique.
                                </div>
                            </div>
                            <button type="submit" id="btn-text-password"
                                class="btn-send-password btn main-btn main-btn-lg full-width">Salvar</button>

                            <div id="spinner-password"
                                class="btn color-white main-btn main-btn-lg btn-send full-width mb-10"
                                style="display: none;">
                                <span style="font-size: 15px;">
                                    <svg style="width: 22px" version="1.1" id="L7"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100"
                                        xml:space="preserve">
                                        <path fill="#fff"
                                            d="M31.6,3.5C5.9,13.6-6.6,42.7,3.5,68.4c10.1,25.7,39.2,38.3,64.9,28.1l-3.1-7.9c-21.3,8.4-45.4-2-53.8-23.3
                                                                                                                                                                                                                                c-8.4-21.3,2-45.4,23.3-53.8L31.6,3.5z">
                                            <animateTransform attributeName="transform" attributeType="XML"
                                                type="rotate" dur="2s" from="0 50 50" to="360 50 50"
                                                repeatCount="indefinite" />
                                        </path>
                                        <path fill="#fff"
                                            d="M42.3,39.6c5.7-4.3,13.9-3.1,18.1,2.7c4.3,5.7,3.1,13.9-2.7,18.1l4.1,5.5c8.8-6.5,10.6-19,4.1-27.7
                                                                                                                                                                                                                                c-6.5-8.8-19-10.6-27.7-4.1L42.3,39.6z">
                                            <animateTransform attributeName="transform" attributeType="XML"
                                                type="rotate" dur="1s" from="0 50 50" to="-360 50 50"
                                                repeatCount="indefinite" />
                                        </path>
                                        <path fill="#fff"
                                            d="M82,35.7C74.1,18,53.4,10.1,35.7,18S10.1,46.6,18,64.3l7.6-3.4c-6-13.5,0-29.3,13.5-35.3s29.3,0,35.3,13.5
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
    <!-- Password-modal -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $('#spinner-email').hide();
        $(document).ready(function() {
            $('.btn-send-email').click(function() {
                $('#spinner-email').prop('disabled', true).show();
                $('#btn-text-email').hide();
            });
        });
    </script>


    <script>
        $('#spinner-name').hide();
        $(document).ready(function() {
            $('.btn-send-name').click(function() {
                $('#spinner-name').prop('disabled', true).show();
                $('#btn-text-name').hide();
            });
        });
    </script>

    <script>
        $('#spinner-password').hide();
        $(document).ready(function() {
            $('.btn-send-password').click(function() {
                $('#spinner-password').prop('disabled', true).show();
                $('#btn-text-password').hide();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            function checkPasswordMatch() {
                var newPassword = $("#new_password").val();
                var confirmNewPassword = $("#confirm_password").val();

                if (newPassword != confirmNewPassword) {
                    $("#passwordMismatch").removeClass("d-none");
                    $("#btn-text-password").prop("disabled", true);
                } else {
                    $("#passwordMismatch").addClass("d-none");
                    $("#btn-text-password").prop("disabled", false);
                }
            }

            $("#new_password, #confirm_password").keyup(checkPasswordMatch);

            $("#passwordForm").submit(function(event) {
                var newPassword = $("#new_password").val();
                var confirmNewPassword = $("#confirm_password").val();

                if (newPassword != confirmNewPassword) {
                    $("#passwordMismatch").removeClass("d-none");
                    $("#btn-text-password").prop("disabled", true).addClass('btn-secondary').removeClass(
                        'main-btn main-btn-lg');
                    event.preventDefault();
                } else {
                    $("#spinner-password").show();
                    $("#btn-text-password").hide();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#upThumb').on('change', function() {
                var formData = new FormData($('#imageUploadForm')[
                    0]);
                $.ajax({
                    url: $('#imageUploadForm').attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        location.reload();
                    }
                });
            });
        });
    </script>
@endsection
