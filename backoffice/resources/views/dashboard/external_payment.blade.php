@extends('livewire.components.main')
@section('content')
    <!-- Header-bg -->
    <div class="header-bg header-bg-1"></div>
    <!-- Header-bg -->

    <div class="body-content">
        <div class="container" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
            <div class="page-header">
                <div class="page-header-title page-header-item">
                    <h3 class="font-size-h3">Falta pouco! Escaneie o código QR pelo seu app de pagamentos ou Internet Banking
                    </h3>
                </div>
            </div>
            <div class="authentication-form margin-top-pix pb-15">
                <div class="pixqrcode">
                    <img class="qrcode" src="data:image/png;base64, {{ $data['qrcode'] }}"alt="" style="height: 400px;">
                </div>
                <div class="boxpix text-center">
                    <h4 class="valuepix text-center mt-4">Valor do PIX a pagar: <span
                            class="stylevaluepix">R${{ number_format($data['value'], 2, ',', '.') }}</span></h4>

                    @if ($data['description'] != '')
                        <h6 class="text-center mt-4">Descrição do pagamento: {{ $data['description'] }}</h6>
                    @endif

                    <div style="display: flex;flex-direction: column;">
                        <h6 class="colorp text-center mt-3">Chave Copia e Cola</h6>
                        <div class="mt-3 mb-3">
                            <p id="copySuccessMessage" class="d-none text-center text-success">Link Copiado!</p>
                        </div>
                        <input class="pixcopiaecola form-control" id="pixInput" type="text"
                            value="{{ $data['copy_past'] }}" readonly>
                        <button onclick="copyToClipboard()" type="button" style="font-size: 14px"
                            class="btn main-btn mt-3 main-btn-lg buttonpix" data-bs-container="body"
                            data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Top popover">Copiar</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="toast-container  position-fixed bottom-0 end-0 p-3">
        <div id="copyToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div id="copyToastBody" class="toast-body bg-success text-white">
                Link copiado para a área de transferência.
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("pixInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");

            // Mostra o toast
            var copyToast = document.getElementById("copyToast");
            var copyToastBody = document.getElementById("copyToastBody");
            copyToastBody.innerText = "Link copiado para a área de transferência.";

            var toast = new bootstrap.Toast(copyToast);
            toast.show();

            setTimeout(function() {
                toast.hide();
            }, 3000);
        }
    </script>
@endsection
