<!-- Add-balance-modal -->
<div class="modal fade" id="addBalance" tabindex="-1" aria-labelledby="addBalance" aria-hidden="true">
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
                    <form action="{{ route('pix.post') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-group mb-15">
                            <label for="input1" class="form-label">Total a Depositar</label>
                            <input type="text" name="value" class="form-control" id="input1"
                                placeholder="Digite a quantidade a Depositar">
                        </div>
                        <button id="btn-text" type="submit" class="btn-send btn main-btn main-btn-lg full-width">Gerar
                            Deposito</button>

                        <div id="spinner" class="btn color-white main-btn main-btn-lg btn-send full-width mb-10">
                            <span style="font-size: 15px;">
                                <svg style="width: 22px" version="1.1" id="L7"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100"
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
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add-balance-modal -->
