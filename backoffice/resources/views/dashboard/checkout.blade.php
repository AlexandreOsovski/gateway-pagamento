@extends('livewire.components.main')
@section('content')
    <div class="body-content">
        <div class="container" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
            <div class="page-header">
                <div class="page-header-title page-header-item">
                    <h3 class="font-size-h3">Falta pouco! Escaneie o código QR pelo seu app de pagamentos ou Internet Banking</h3>
                </div>
            </div>
            <div class="authentication-form margin-top-pix pb-15">
                <div class="pixqrcode">
                    <img class="qrcode" src="data:image/png;base64, {{$data['qrcode']}}"alt="">
                </div>
                <div class="boxpix ">
                    <h4 class="valuepix text-center mt-4">Valor do PIX a pagar: <span class="stylevaluepix">R${{number_format(($data['amount']), 2, ',', '.' )}}</span></h4>
                    <div style="display: flex;flex-direction: column;">
                        <h6 class="colorp text-center mt-3">Chave Copia e Cola</h6>
                        <input class="pixcopiaecola form-control" id="pixInput" type="text" value="{{$data['pixCopy']}}" readonly>
                        <button onclick="copyToClipboard()" type="submit" style="font-size: 14px" class="btn main-btn mt-3 main-btn-lg buttonpix">Copiar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("pixInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            alert("Chave copiada: " + copyText.value);
        }
    </script>
@endsection
