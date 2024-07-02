<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Flasher\Toastr\Laravel\Facade\Toastr;

use Illuminate\{
    Http\Request,
    Support\Facades\Auth,
    Support\Facades\Http,
    Support\Facades\Validator
};

use App\Models\{
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
    private string $secretKey;

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
    private string $apiSecret;

    /**
     * @var string
     */
    private string $webHookVega;


    public string $urlPostBack;

    public function __construct()
    {
        $this->secretKey = '1e9fee004b24cad7a7fea4cb9bd36d0c4f1e972ex';
        $this->integrationApiUrl = "https://api-br.x-pay.app";
        $this->version = 'v2';
        $this->url = "{$this->integrationApiUrl}/{$this->version}/";

//        if (env('APP_ENV') == "production") {
//            $this->urlPostBack = env('APP_URL') . "/api/webhook-pix";
//        }else{
        $this->urlPostBack = "https://pay.horiizom.com/api/webhook-pix";
//        }

    }

    private function prepareAuthorizationData(): array
    {
        return [
            'clientId' => '2ae8fb7e-8b6d-4c21-b400-e63373fbcc3c',
            'clientSecret' => 'D392B342-39CF-4EA7-9346-7056886F8F77',
            'webhook_url' => $this->urlPostBack,
        ];
    }

    private function authorization(): array
    {
        $data = $this->prepareAuthorizationData();


        $response = Http::withHeaders([
            'authorizationToken' => '1e9fee004b24cad7a7fea4cb9bd36d0c4f1e972ex',
            'Content-Type' => 'application/json',
        ])->post($this->url . 'token', $data);

        return json_decode($response->body(), true);
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

        $rules = [
            'value' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $validatedData = $validator->validated();

        $documentNumber = '520.918.390-43';
        $documentNumber = preg_replace('/\D/', '', $documentNumber);

        $amountInCents = (float)$validatedData['value'];
        $accessToken = $this->authorization()['access_token'];

        $transactionData = [
            "PixKey" => "financeiro@2mpayments.com.br",
            "TaxNumber" => "44456489000186",
            "Bank" => "450",
            "BankAccount" => "883770778",
            "BankAccountDigit" => "8",
            "BankBranch" => "0001",
            "PrincipalValue" => 0.01,
            "webhook_url" => $this->urlPostBack

        ];

        $response = Http::withHeaders([
            'authorizationToken' => '1e9fee004b24cad7a7fea4cb9bd36d0c4f1e972ex',
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

    public function createIntentionPix(Request $request): mixed
    {
        try {
            $transaction = new TransactionModel();
            $transaction->client_id = Auth::guard('client')->user()->id;
            $transaction->method_payment = 'PIX';
            $transaction->type_key = $request->type_key;
            $transaction->amount = $request->amount;
            $transaction->address = $request->address;
            $transaction->status = 'waiting_approval';
            $transaction->save();

            Toastr('Transação PIX realizada com sucesso! Aguardando aprovação! Iremos verificar os detalhes e processar a transação. Pode levar algum tempo para o dinheiro estar disponível em sua conta de destino.');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Erro ao criar transação PIX!', $e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Create a transfer PIX.
     *
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createTransferPix(Request $request): mixed
    {

        if ($request->header('authorizationAdmin') != env('KEY_TRANSFER_PIX')) {
            return response()->json('unauthorized', 401);
        }

        $rules = [
            'id' => 'required',
            'client_id' => 'required',
            'amount' => 'required|numeric',
            'pixKey' => 'required|string',
            'externalRef' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $amountInCents = intval($validatedData['amount'] * 100);

        $transferData = [
            'amount' => $amountInCents,
            'pixKey' => $validatedData['pixKey'],
            'externalRef' => $validatedData['externalRef']
        ];

        $client = ClientModel::where('id', $validatedData['client_id'])->first();

        if ($client->balance < $validatedData['amount']) {
            return response()->json('unauthorized', 401);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode("{$this->secretKey}:x"),
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post($this->url . 'transfers', $transferData);

        if ($response['status'] === 'pending' || $response['status'] === 'success') {

            $client->balance -= $validatedData['amount'];
            $client->save();

            $notification = new NotificationModel();
            $notification->client_id = $validatedData['client_id'];
            $notification->title = 'Transferencia de PIX';
            $notification->body = "Transferencia PIX no valor de R$ $validatedData[amount] realizada com sucesso";
            $notification->icon = 'fa-solid fa-money-bill';
            $notification->save();


            $movement = new MovementModel();
            $movement->client_id = $validatedData['client_id'];
            $movement->type = 'EXIT';
            $movement->type_movement = 'WITHDRAW';
            $movement->amount = $validatedData['amount'];
            $movement->description = "Transferencia de PIX para outra instituicao";
            $movement->save();

            return response()->json($response, 200);
        } else {
            $notification = new NotificationModel();
            $notification->client_id = $validatedData['client_id'];
            $notification->title = 'Erro Transferencia de PIX';
            $notification->body = "Ocorreu um erro na transferencia PIX no valor de R$ " . number_format($validatedData["amount"], 2, ',', '.');
            $notification->icon = 'fa-solid fa-money-bill';
            $notification->save();

            return response()->json($response->body(), 400);
        }
    }

    /**
     * Create a transfer Bank Account.
     *
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createTransferBank(Request $request): mixed
    {
        $rules = [
            'amount' => 'required|numeric',
            'bankAccount' => 'required|array',
            'bankAccount.bankCode' => 'required|string',
            'bankAccount.agencyNumber' => 'required|string',
            'bankAccount.accountNumber' => 'required|string',
            'bankAccount.accountDigit' => 'required|string',
            'bankAccount.type' => 'required|string',
            'bankAccount.legalName' => 'required|string',
            'bankAccount.documentNumber' => 'required|string',
            'bankAccount.documentType' => 'required|string|in:cpf,cnpj',
            'externalRef' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $amountInCents = intval($validatedData['amount'] * 100);

        $transferData = [
            'amount' => $amountInCents,
            'bankAccount' => [
                'bankCode' => $validatedData['bankAccount']['bankCode'],
                'agencyNumber' => $validatedData['bankAccount']['agencyNumber'],
                'accountNumber' => $validatedData['bankAccount']['accountNumber'],
                'accountDigit' => $validatedData['bankAccount']['accountDigit'],
                'type' => $validatedData['bankAccount']['type'],
                'legalName' => $validatedData['bankAccount']['legalName'],
                'document' => [
                    'number' => $validatedData['bankAccount']['documentNumber'],
                    'type' => $validatedData['bankAccount']['documentType']
                ],
            ],
            'externalRef' => $validatedData['externalRef']
        ];

        $response = $this->post('/transfers', $transferData);

        if ($response['status'] === 'pending' || $response['status'] === 'success') {
            return response()->json($response, 200);
        } else {
            return response()->json($response, 400);
        }
    }

    /**
     * Create a customer.
     *
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createCustomer(Request $request): mixed
    {
        if ($request->header('X-API-SECRET') !== $this->apiSecret) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $authorizationHeader = $request->header('Authorization');
        if (!$authorizationHeader) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = str_replace('Bearer ', '', $authorizationHeader);
        $tokenExists = Tokens::where('token', $token)->exists();

        if (!$tokenExists) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $tokenModel = Tokens::where('token', $token)->first();

        $rules = [
            'payerName' => 'required|string',
            'payerEmail' => 'required|string',
            'payerDocument' => 'required|string',
            'payerDocumentType' => 'required|string|in:cpf,cnpj',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $documentNumber = $validatedData['payerDocument'];
        $documentNumber = preg_replace('/\D/', '', $documentNumber);

        $data = [
            'name' => $validatedData['payerName'],
            'email' => $validatedData['payerEmail'],
            'document' => [
                'number' => $documentNumber,
                'type' => $validatedData['payerDocumentType'],
            ]
        ];

        $response = $this->post('/customers', $data);

        if (isset($response['id'])) {
            return response()->json($response, 200);
        } else {
            return response()->json($response, $response['status']);
        }
    }

    /**
     * Get transanction by Id
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getTransaction(Request $request): mixed
    {
        if ($request->header('X-API-SECRET') !== $this->apiSecret) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $authorizationHeader = $request->header('Authorization');
        if (!$authorizationHeader) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = str_replace('Bearer ', '', $authorizationHeader);
        $tokenExists = Tokens::where('token', $token)->exists();

        if (!$tokenExists) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $rules = [
            'id' => 'required|numeric'
        ];

        $validator = Validator::make($request->all, $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $validatedData = $validator->validated();

        return $this->get('transactions/' . $validatedData['id']);
    }

    /**
     * Reverse as Transaction
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reverseTransaction(Request $request): mixed
    {
        if ($request->header('X-API-SECRET') !== $this->apiSecret) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $authorizationHeader = $request->header('Authorization');
        if (!$authorizationHeader) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = str_replace('Bearer ', '', $authorizationHeader);
        $tokenExists = Tokens::where('token', $token)->exists();

        if (!$tokenExists) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $rules = [
            'id' => 'required|numeric',
            'amount' => 'required|numeric'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $validatedData = $validator->validated();

        return $this->post('transactions/' . $validatedData['id'] . '/refund', $validatedData);
    }

    /**
     * Generate a QR Code
     *
     * @param string $pixCopyPaste
     * @return string
     */
    public function generateQrCode($pixCopyPaste)
    {
        $qrCode = new QrCode($pixCopyPaste);
        $qrCode->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
            ->setSize(300)
            ->setMargin(10);

        $writer = new PngWriter();

        $qrCodeOutput = $writer->write($qrCode);
        $qrCodeDataUri = $qrCodeOutput->getDataUri();

        $base64 = substr($qrCodeDataUri, strpos($qrCodeDataUri, ",") + 1);

        return $base64;
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
                $this->makeNotification($client->id, $userBalance);
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
    public function makeNotification($client_id, $amount)
{
    $notification = new NotificationModel();
    $notification->icon = 'fa-solid fa-money-bill';
    $notification->client_id = $client_id;
    $notification->title = 'Deposito PIX';
    $notification->body = 'Voce realizou um deposito total via PIX no valor de: R$' . number_format($amount, 2, ',', '.') . ' (Valor total retirando as taxas)';
    $notification->save();
}

}
