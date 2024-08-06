<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Jobs\PixCreateJob;
use Illuminate\{
    Http\Request,
    Support\Facades\Http,
    Support\Facades\Validator
};

use App\Models\{
    TokenModel,
    AdminModel,
    ClientModel,
    MovementModel,
    PixApiModel,
    WebhookNotificationModel,
    NotificationModel,
};

use App\Services\{
    ClientService,
    KeysApiService
};


class XpayPixApi extends Controller
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

    public string $apiSecret;

    public TokenModel $token;

    public $keysApiService;
    public $clientService;

    public function __construct(KeysApiService $keysApiService, ClientService $clientService)
    {
        $this->key_api = env('AUTHORIZATION_TOKEN');

        $this->integrationApiUrl = "https://api-br.x-pay.app";
        $this->version = 'v2';
        $this->url = "{$this->integrationApiUrl}/{$this->version}/";

        if (env('APP_TEST') == true) {
            $url = 'https://homolog.horiizom.com';
        } else {
            $url = 'https://pay.horiizom.com';
        }

        $this->urlPostBack = "$url/api/v1/pix/webhook";
        $this->pix_key = '69655432-eafe-44b0-934c-3ebd6d6be06c';

        $this->apiSecret = env('API_SECRET_KEY');
        $this->token = new TokenModel();
        $this->keysApiService = $keysApiService;
        $this->clientService = $clientService;
    }

    private function dataToPix(float $value): array
    {
        return [
            "PixKey" => $this->pix_key,
            "TaxNumber" => "33482384000185",
            "Bank" => "450",
            "BankAccount" => "4992752153",
            "BankAccountDigit" => "0",
            "BankBranch" => "0001",
            "PrincipalValue" => $value,
            "webhook_url" => $this->urlPostBack

        ];
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
        if ($request->header('X-API-SECRET') !== $this->apiSecret) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $authorizationHeader = $request->header('Authorization');
        if (empty($authorizationHeader)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        $token = str_replace('Bearer ', '', $authorizationHeader);
        $tokenExists = $this->token::where('token', $token)->exists();

        if (empty($tokenExists)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        $tokenModel = $this->token::where('token', $token)->first();
        $keysApi = $this->keysApiService->getByAppIdAndAppKey($tokenModel->appId, $tokenModel->appKey);

        if (empty($keysApi)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        if ($request->input('value') < 1) {
            return response()->json(['error' => 'O valor mínimo é de R$1,00.'], 422);
        }


        $rules = [
            'value' => 'required|numeric',
            'url_webhook' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $response = Http::withHeaders([
            'authorizationToken' => $this->key_api,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post($this->url . 'pix/create', $this->dataToPix($validatedData['value']));

        $client  = $this->clientService->find($keysApi['client_id']);

        if ($response->status() == 201) {
            $data = [
                "pixCopy" => $response['qrCodeData']['QRCodeCopiaeCola'],
                "payerName" => $client->name,
                "payerDocument" => $client->document_number,

                "client_uuid" => $client->uuid,
                "txId" => $response['qrCodeData']['Identifier'],
                "order_id" => $response['qrCodeData']['Identifier'],
                'appId' => $request->appId == '' ? '0' : $request->appId,
                'token' => $token,
                "amount" => $validatedData['value'],
                "external_reference" => $response['qrCodeData']['Identifier'],
                "status" => 'pending',
                "url_webhook" => $validatedData['url_webhook'],
                "qrcode" => $response['qrCodeData']['QRCodeBase64'],

                "expirationDate" => 1,
                "created_at" => now(),
            ];

            PixCreateJob::dispatch($data, $token)->delay(now()->addSeconds(5))->onQueue('pix-insert');

            return response()->json($data, 200);
        } else {
            return response()->json($response, 400);
        }
    }

    /**
     * Summary of statusTransactionPix
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function statusTransactionPix(Request $request): mixed
    {
        if ($request->header('X-API-SECRET') !== $this->apiSecret) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $authorizationHeader = $request->header('Authorization');
        if (empty($authorizationHeader)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = str_replace('Bearer ', '', $authorizationHeader);
        $tokenExists = $this->token::where('token', $token)->exists();

        if (empty($tokenExists)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $tokenModel = $this->token::where('token', $token)->first();
        $keysApi = $this->keysApiService->getByAppIdAndAppKey($tokenModel->appId, $tokenModel->appKey);

        if (empty($keysApi)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $rules = [
            'external_reference' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $data = [
            'Identifier' => $validatedData['external_reference'],
            "Bank" => "450",
            "BankAccount" => "4992752153",
            "BankAccountDigit" => "0",
            "BankBranch" => "0001",
        ];

        $response = Http::withHeaders([
            'authorizationToken' => $this->key_api,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post($this->url . 'pix/status', $data);

        return $response;
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

        if (empty($data)) {
            return response()->json('need webhook data', '500');
        }

        $webhookNotification = new WebhookNotificationModel();
        $webhookNotification->event = 'update_payment';
        $webhookNotification->data = json_encode($data);
        $webhookNotification->save();

        if ($data['data']['Method'] == 'PixIn' && $data['data']['Status'] == 'Paid') {

            $order = PixApiModel::where('order_id', $data['data']['QRCodeInfos']['Identifier'])->first();

            if ($order) {
                $order->status = 'approved';
                $order->save();
                $client_uuid = $order->client_uuid;

                if ($data['data']['Value'] > 29.00) {
                    $adminBalance = ($data['data']['Value'] * 4.99) / 100;
                } else {
                    $adminBalance = 1.50;
                }

                $admin = AdminModel::find(1);
                $admin->balance += $adminBalance;
                $admin->save();

                $client = ClientModel::where('uuid', $client_uuid)->first();
                $userBalance = $data['data']['Value'] - $adminBalance;
                $client->balance += $userBalance;
                $client->save();

                $this->makeMovement($client->id, 'ENTRY', 'DEPOSIT', $userBalance, 'Deposito PIX', 'completed');

                $description = 'Entrada PIX no valor de: R$' . number_format($data['data']['Value'], 2, ',', '.') . ' (Valor total retirando as taxas)';
                $this->makeNotification($client->id, $userBalance, 'Deposito PIX', $description);

                Http::post($order->url_webhook, $data);

                return response()->json(['message' => 'Webhook received'], 200);
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
    public function makeMovement($client_id, $type, $type_movements, $amount, $description, $status)
    {
        $movement = new MovementModel();
        $movement->client_id = $client_id;
        $movement->type = $type;
        $movement->type_movement = $type_movements;
        $movement->amount = $amount;
        $movement->description = $description;
        $movement->status = $status;
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