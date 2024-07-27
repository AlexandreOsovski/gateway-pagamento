<?php

namespace App\Livewire\Components\Modals;

use App\Models\ExternalPaymentPixModel;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;

class LinkPayment extends Component
{
    public $value;
    public $description;
    public $hash;

    protected $rules = [
        'value' => 'required|numeric',
        'description' => 'required|string',
    ];

    public function render()
    {
        return view('livewire.components.modals.link-payment');
    }

    public function makeLinkPaymentPix()
    {
        $transactionData = [
            "PixKey" => "69655432-eafe-44b0-934c-3ebd6d6be06c",
            "TaxNumber" => "33482384000185",
            "Bank" => "450",
            "BankAccount" => "4992752153",
            "BankAccountDigit" => "0",
            "BankBranch" => "0001",
            "PrincipalValue" => (float)$this->value,
            "webhook_url" => 'https://homolog.horiizom.com/api/webhook-pix',
        ];

        $response = Http::withHeaders([
            'authorizationToken' => '1e9fee004b24cad7a7fea4cb9bd36d0c4f1e972ex',
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post('https://api-br.x-pay.app/v2/pix/create', $transactionData);

        if ($response->status() == 201) {
            $data = [
                'client_uuid' => Auth::guard('client')->user()->uuid,
                'external_reference' => $response['qrCodeData']['Identifier'],
                'description' => $this->description,
                'value' => $this->value,
                'qrcode' => $response['qrCodeData']['QRCodeBase64'],
                'copy_past' => $response['qrCodeData']['QRCodeCopiaeCola'],
                'status' => 'pending',
                "expirationDate" => 1,
                "created_at" => now(),
            ];

            $externalData = ExternalPaymentPixModel::create($data);
            $paymentData = [
                'id' => $externalData->id,
                'external_reference' => $externalData->external_reference,
                'client_uuid' => $externalData->client_uuid,
                'description' => $data['description'],
            ];

            if (env('APP_ENV') == 'local') {
                $url = env('APP_URL');
            } else {
                $url = 'https://pay.horiizom.com';
            }

            $this->hash = "$url/make-payment?vNQt4LbQj3mL935p09jlBRF1t1vqkrCEldSVKIOELzI=" . JWT::encode($paymentData, env('APP_JWT_KEY'), 'HS256');
        }
    }
}
