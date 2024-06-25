<!-- Exchange-modal -->
<div class="modal fade" id="exchange" tabindex="-1" aria-labelledby="exchange" aria-hidden="true" data-bs-backdrop="static" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="container">
                <div class="modal-header">
                    <div class="modal-header-title">
                        <h5 class="modal-title">Converter</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group mb-15">
                            <label for="input9" class="form-label">Valor em Reais</label>
                            <input type="email" class="form-control" id="valueBRL" wire:model.live="valueBRL" placeholder="BRL">
                        </div>
                        <div class="form-group mb-15">
                            <label for="input10" class="form-label">Valor em USDT</label>

                            <input readonly class="form-control" style="font-size: 16px;" value="{{ $valueUSD }}" wire:loading.remove wire:target="valueBRL"/>
{{--                            <span wire:loading wire:target="valueBRL" style="display:none;">Efetuando conversão...</span>--}}
                        </div>
                        <div class="form-group mb-15">
                            <label for="input4" class="form-label">Codigo 2FA</label>
                            <input type="email" class="form-control" id="input4"
                                placeholder="Digite o codigo enviado ao seu email.">
                        </div>

                        <button type="button" class="btn btn-send main-btn main-btn-lg full-width" id="botaoComprar" wire:loading.remove
                                wire:target="valueBRL" wire:click="convertBalance">
                    <span id="spinner" class="spinner-border spinner-border-sm me-2" wire:loading
                          wire:target="convertBalance"></span>
                            <span class="button-text" id="btn-comprar" wire:loading.remove="opacity-50"
                                  wire:target="convertBalance">Converter</span>
                        </button>
                        <button type="button" class="btn btn-send main-btn main-btn-lg full-width" style="display:none;"
                                id="botaoCarregando" wire:loading wire:target="valueBRL">
                            <span id="spinner" class="spinner-border spinner-border-sm me-2" wire:loading></span>
                            Carregando...
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // document.getElementById('valueBRL').addEventListener('input', function(e) {
    //     e.target.value = Math.max(0, parseInt(e.target.value)).toString().replace(/[^0-9]/g,
    //         '');
    // });
</script>
<!-- Exchange-modal -->
