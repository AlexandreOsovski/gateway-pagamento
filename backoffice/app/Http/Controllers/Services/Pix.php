<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use Flasher\Toastr\Laravel\Facade\Toastr;

use Illuminate\{
    Http\Request,
    Support\Facades\Auth,
    Support\Facades\Http,
    Support\Facades\Validator
};

use App\Models\{
    ExternalPaymentPixModel,
    TokenModel,
    OrderCreditModel,
    AdminModel,
    ClientModel,
    MovementModel,
    TransferUserToUserModel,
    KeysApiModel,
    PixApiModel,
    WebhookNotificationModel,
    NotificationModel,
    TransactionModel
};

use Endroid\QrCode\{
    QrCode,
    Encoding\Encoding,
    ErrorCorrectionLevel,
    Writer\PngWriter,
};
use App\Jobs\PixCreateJob;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class Pix extends Controller
{
    /**
     * @var string
     */
    private string $key_api;

    /**
     * @var string
     */
    private string $integrationApiUrl;

    /**
     * @var string
     */
    private string $version;

    /**
     * @var string
     */
    private string $url;

    /**
     * @var string
     */

    private string $pix_key;
    public string $urlPostBack;

    public function __construct()
    {
        $this->key_api = '1e9fee004b24cad7a7fea4cb9bd36d0c4f1e972ex';
        $this->integrationApiUrl = "https://api-br.x-pay.app";
        $this->version = 'v2';
        $this->url = "{$this->integrationApiUrl}/{$this->version}/";
        $this->urlPostBack = 'https://pay.horiizom.com/api/webhook-pix';
        $this->pix_key = '69655432-eafe-44b0-934c-3ebd6d6be06c';
    }

    /**
     * Create a transaction pix.
     *
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createTransactionPix(Request $request): mixed
    {
        if ($request->input('value') < 1) {
            toastr('O valor minimo de deposito e R$1,00', 'error');
            return redirect()->back();
        }

        $rules = [
            'value' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            toastr($validator->errors()->messages()['value'][0], 'error');
            return redirect()->back();
        }

        $validatedData = $validator->validated();

        $transactionData = [
            "PixKey" => $this->pix_key,
            "TaxNumber" => "44456489000186",
            "Bank" => "450",
            "BankAccount" => "883770778",
            "BankAccountDigit" => "8",
            "BankBranch" => "0001",
            "PrincipalValue" => (float)$validatedData['value'],
            "webhook_url" => $this->urlPostBack

        ];

        $response = Http::withHeaders([
            'authorizationToken' => $this->key_api,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post($this->url . 'pix/create', $transactionData);

        if ($response->status() == 201) {
            $data = [
                "pixCopy" => $response['qrCodeData']['QRCodeCopiaeCola'],
                "payerName" => Auth::guard('client')->user()->name,
                "payerDocument" => Auth::guard('client')->user()->document_number,

                "client_uuid" => Auth::guard('client')->user()->uuid,
                "txId" => $response['qrCodeData']['Identifier'],
                "order_id" => $response['qrCodeData']['Identifier'],
                'appId' => $request->appId == '' ? '0' : $request->appId,
                'token' => Auth::guard('client')->user()->uuid,
                "amount" => $validatedData['value'],
                "external_reference" => $response['qrCodeData']['Identifier'],
                "status" => 'pending',
                "qrcode" => $response['qrCodeData']['QRCodeBase64'],

                "expirationDate" => 1,
                "created_at" => now(),
            ];

            PixCreateJob::dispatch($data, Auth::guard('client')->user()->uuid)->delay(now()->addSeconds(5))->onQueue('pix-insert');

            return view('dashboard.checkout', ['data' => $data]);
        } else {
            return response()->json($response, 400);
        }
    }


    public function makeLinkPaymentPix(Request $request): mixed
    {
        if ($request->input('value') < 1) {
            toastr('O valor minimo de deposito e R$1,00', 'error');
            return redirect()->back();
        }


        $rules = [
            'value' => 'required|numeric',
            'description' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            toastr($validator->errors()->messages()['value'][0], 'error');
            return redirect()->back();
        }

        $validatedData = $validator->validated();

        $transactionData = [
            "PixKey" => $this->pix_key,
            "TaxNumber" => "44456489000186",
            "Bank" => "450",
            "BankAccount" => "883770778",
            "BankAccountDigit" => "8",
            "BankBranch" => "0001",
            "PrincipalValue" => $validator['value'],
            "webhook_url" => $this->urlPostBack

        ];

        $response = Http::withHeaders([
            'authorizationToken' => $this->key_api,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post($this->url . 'pix/create', $transactionData);

        if ($response->status() == 201) {
            $data = [
                'client_uuid' => Auth::guard('client')->user()->uuid,
                'external_reference' => $response['qrCodeData']['Identifier'],
                'description' => $validatedData['description'],
                'value' => $validatedData['value'],
                'status' => 'pending',
                "expirationDate" => 1,
                "created_at" => now(),
            ];

            ExternalPaymentPixModel::created($data);

            $encode_data = JWT::encode($data, env('APP_JWT_KEY'), 'HS256');
            return view('dashboard.external_payment', ['data' => $encode_data]);
        }
        return false;
    }

    public function createIntentionPix(Request $request): mixed
    {

        if ((float)$request->amount > Auth::guard('client')->user()->balance) {
            Toastr('Saldo insuficiente', 'error');
            return redirect()->back();
        } else {
            try {
                $transaction = new TransactionModel();
                $transaction->client_id = Auth::guard('client')->user()->id;
                $transaction->method_payment = 'PIX';
                $transaction->type_key = $request->type_key;
                $transaction->amount = $request->amount;
                $transaction->address = $request->address;
                $transaction->status = 'waiting_approval';
                $transaction->save();

                MovementModel::create([
                    'client_id' => $transaction->client_id,
                    'type' => 'EXIT',
                    'type_movement' => 'TRANSFER',
                    'amount' => (float)$request->amount,
                    'description' => 'Transação PIX realizada com sucesso! Aguardando aprovação! Iremos verificar os detalhes e processar a transação. Pode levar algum tempo para o dinheiro estar disponível em sua conta de destino.',
                ]);

                Toastr('Transação PIX realizada com sucesso! Aguardando aprovação! Iremos verificar os detalhes e processar a transação. Pode levar algum tempo para o dinheiro estar disponível em sua conta de destino.');
                return redirect()->back();
            } catch (\Exception $e) {
                Alert::error('Erro ao criar transação PIX!', $e->getMessage());
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        }
    }

    /**
     * Webhook
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function webHook(Request $request)
    {
        $data = $request->all();

        $webhookNotification = new WebhookNotificationModel();
        $webhookNotification->event = 'update_payment';
        $webhookNotification->data = json_encode($data);
        $webhookNotification->save();

        if (empty($data)) {
            return response()->json('need webhook data', '500');
        }

        $orderId = null;
        if ($data['data']['Method'] == 'PixIn' && $data['data']['Status'] == 'Paid') {
            $order = PixApiModel::where('order_id', $data['data']['QRCodeInfos']['Identifier'])->first();

            if ($order) {
                $order->status = 'approved';
                $order->save();
                $client_uuid = $order->client_uuid;

                $admin = AdminModel::find(1);
                $adminBalance = ($data['data']['Value'] * 20) / 100;
                $admin->balance += $adminBalance;
                $admin->save();

                $client = ClientModel::where('uuid', $client_uuid)->first();
                $userBalance = ($data['data']['Value'] * 80) / 100;
                $client->balance += $userBalance;
                $client->save();

                $this->makeMovement($client->id, 'ENTRY', 'DEPOSIT', $userBalance, 'Deposito PIX');

                $description = 'Voce realizou um deposito total via PIX no valor de: R$' . number_format($data['data']['Value'], 2, ',', '.') . ' (Valor total retirando as taxas)';
                $this->makeNotification($client->id, $userBalance, 'Deposito PIX', $description);

                return response()->json(['message' => 'Webhook received'], 200);
            } else {

                $externalPayment = ExternalPaymentPixModel::where('external_reference', $data['data']['QRCodeInfos']['Identifier'])->first();
                if ($externalPayment) {
                    $externalPayment->status = 'paid';
                    $externalPayment->save();

                    $client_uuid = $externalPayment->client_uuid;

                    $admin = AdminModel::find(1);
                    $adminBalance = ($data['data']['Value'] * 20) / 100;
                    $admin->balance += $adminBalance;
                    $admin->save();

                    $client = ClientModel::where('uuid', $client_uuid)->first();
                    $userBalance = ($data['data']['Value'] * 80) / 100;
                    $client->balance += $userBalance;
                    $client->save();

                    $this->makeMovement($client->id, 'ENTRY', 'DEPOSIT', $userBalance, 'Pagamento externo realizado por: ' . $data['data']['FromName']);

                    $description = 'Pagamento externo realizado com sucesso por: ' . $data['data']['FromName'] . ' No valor de: R$' . number_format($data['data']['value'], 2, ',', '.');
                    $this->makeNotification($client->id, $userBalance, 'Pagamento Externo', $description);

                    return response()->json(['message' => 'Webhook received'], 200);
                }
            }
        }
    }

    /**
     * Register a financial movement.
     *
     * @param int $client_id The ID of the client associated with the movement.
     * @param string $type The type of financial movement (for example, 'entry' or 'out').
     * @param string $type_movements The specific type of movement (e.g. 'Deposit' or 'Commission').
     * @param float $amount The value of the financial movement.
     * @param string $description A description of the financial movement.
     * @return null
     */
    public function makeMovement($client_id, $type, $type_movements, $amount, $description)
    {
        $movement = new MovementModel();
        $movement->client_id = $client_id;
        $movement->type = $type;
        $movement->type_movement = $type_movements;
        $movement->amount = $amount;
        $movement->description = $description;
        $movement->save();
    }

    /**
     * Records a transfer of value from one user to another.
     *
     * @param int $client_id The ID of the customer making the payment.
     * @param int $client_pay_id The ID of the customer receiving the payment.
     * @param float $amount The transfer amount.
     * @return void
     */
    public function makeNotification($client_id, $amount, $title, $description)
    {
        $notification = new NotificationModel();
        $notification->icon = 'fa-solid fa-money-bill';
        $notification->client_id = $client_id;
        $notification->title = $title;
        $notification->body = $description;
        $notification->save();
    }
}
