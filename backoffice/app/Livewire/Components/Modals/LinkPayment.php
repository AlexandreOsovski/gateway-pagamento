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
            "PixKey" => "financeiro@2mpayments.com.br",
            "TaxNumber" => "44456489000186",
            "Bank" => "450",
            "BankAccount" => "883770778",
            "BankAccountDigit" => "8",
            "BankBranch" => "0001",
            "PrincipalValue" => (float)$this->value,
            "webhook_url" => 'http://34.224.87.193/api/webhook-pix',
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
            ];

            $this->hash = env('APP_URL') . '/make-payment?vNQt4LbQj3mL935p09jlBRF1t1vqkrCEldSVKIOELzI=' . JWT::encode($paymentData, env('APP_JWT_KEY'), 'HS256');
        }
    }
}