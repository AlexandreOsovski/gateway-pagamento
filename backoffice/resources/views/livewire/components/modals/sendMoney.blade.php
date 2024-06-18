<!-- Send-money-modal -->
<div class="modal fade" id="sendMoney" tabindex="-1" aria-labelledby="sendMoney" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="container">
                <div class="modal-header">
                    <div class="modal-header-title">

                        <h5 class="modal-title">P2P</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('transferUserToUser.post') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-group mb-15">
                            <label for="input6" class="form-label">Email ou Codigo de Usuário</label>
                            <input type="text" name="code_or_email" class="form-control" id="input6"
                                placeholder="Digite o Email ou Codigo de Usuário">
                        </div>
                        <div class="form-group mb-15">
                            <label for="input5" class="form-label">Valor a Transferir</label>
                            <input type="text" name="value" class="form-control" id="input5"
                                placeholder="Digite o valor a ser enviado.">
                        </div>
                        <div class="form-group mb-15">
                            <label for="input4" class="form-label">Codigo 2FA</label>
                            <input type="email" class="form-control" id="input4"
                                placeholder="Digite o codigo enviado ao seu email.">
                        </div>
                        <button id="btn-text" type="submit"
                            class="btn-send btn main-btn main-btn-lg full-width">Transferir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Send-money-modal -->
