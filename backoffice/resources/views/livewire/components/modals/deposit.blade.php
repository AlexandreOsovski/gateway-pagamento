<!-- Add-balance-modal -->
<div class="modal fade" id="addBalance" tabindex="-1" aria-labelledby="addBalance" aria-hidden="true"
    data-bs-backdrop="static" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="container">
                <div class="modal-header">
                    <div class="modal-header-title">
                        <h5 class="modal-title">Depositar</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group mb-15">
                            <label for="input1" class="form-label">Total a Depositar</label>
                            <input id="valueBRL" wire:model.live="valueBRL" type="text" class="form-control"
                                id="input1" placeholder="Digite a quantidade a Depositar">
                        </div>

                        <button type="button" class="btn btn-send main-btn main-btn-lg full-width" id="botaoComprar"
                            wire:loading.remove wire:target="valueBRL" wire:click="convertBalance">
                            <span id="spinner" class="spinner-border spinner-border-sm me-2" wire:loading
                                wire:target="deposit"></span>
                            <span class="button-text" id="btn-comprar" wire:loading.remove="opacity-50"
                                wire:target="deposit">Converter</span>
                        </button>
                        <button type="button" class="btn btn-send main-btn main-btn-lg full-width"
                            style="display:none;" id="botaoCarregando" wire:loading wire:target="valueBRL">
                            <span id="spinner" class="spinner-border spinner-border-sm me-2" wire:loading></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add-balance-modal -->
