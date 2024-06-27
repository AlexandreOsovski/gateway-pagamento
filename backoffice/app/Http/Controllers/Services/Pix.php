<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\NotificationModel;
use Flasher\Toastr\Laravel\Facade\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\TokenModel;
use App\Models\OrderCreditModel;
use App\Models\AdminModel;
use App\Models\ClientModel;
use App\Models\MovementModel;
use App\Models\TransferUserToUserModel;
use App\Models\KeysApiModel;
use App\Models\PixApiModel;
use App\Models\WebhookNotificationModel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use App\Jobs\PixCreateJob;
use Illuminate\Support\Facades\Log;

class Pix extends Controller
{
    /**
     * @var string
     */
    private string $secretKey;

    /**
     * @var string
     */
    private string $path;

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

    public function __construct()
    {
        $this->secretKey = "sk_live_LTWpzZcO0T8mkgmVh7JDSYn7nE5BhVAp4JT3UmdVZF";
        $this->path = "https://api.spacefybrasil.com.br";
        $this->version = 'v1/';
        $this->url = "{$this->path}/{$this->version}";
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

        $amountInCents = intval($validatedData['value'] * 100);

        $transactionData = [
            'amount' => $amountInCents,
            'paymentMethod' => 'pix',
            'externalRef' => Auth::guard('client')->user()->uuid,
            'pix' => [
                'expiresInDays' => 1
            ],
            'customer' => [
                'name' => Auth::guard('client')->user()->name,
                'email' => Auth::guard('client')->user()->email,
                'document' => [
                    'number' => $documentNumber,
                    'type' => strtolower(Auth::guard('client')->user()->document_type),
                ],
            ],
            'items' => [
                [
                    'title' => 'Deposito PIX',
                    'unitPrice' => $amountInCents,
                    'quantity' => 1,
                    'tangible' => true
                ]
            ],
            'postbackUrl' => "http://34.224.87.193/api/webhook-pix"
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode("{$this->secretKey}:x"),
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post('https://api.spacefybrasil.com.br/v1/transactions', $transactionData);

        if ($response['status'] === 'waiting_payment') {
            $pixCopyPaste = $this->generateQrCode($response['pix']['qrcode']);
            $data = [
                "pixCopy" => $response['pix']['qrcode'],
                "payerName" => $response['customer']['name'],
                "payerDocument" => $response['customer']['document']['number'],

                "client_uuid" => Auth::guard('client')->user()->uuid,
                "txId" => $response['id'],
                "order_id" => uniqid(),
                'appId' => $request->appId == '' ? '0' : $request->appId,
                'token' => Auth::guard('client')->user()->uuid,
                "amount" => $validatedData['value'],
                "external_reference" => Auth::guard('client')->user()->uuid,
                "status" => 'pending',
                "qrcode" => $pixCopyPaste,

                "expirationDate" => $response['pix']['expirationDate'],
                "created_at" => $response['createdAt'],
            ];

            PixCreateJob::dispatch($data, Auth::guard('client')->user()->uuid)->delay(now()->addSeconds(5))->onQueue('pix-insert');

            return view('dashboard.checkout', ['data' => $data]);
        } else {
            return response()->json($response, 400);
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
        $rules = [
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

        $response = $this->post('/transfers', $transferData);

        if ($response['status'] === 'pending' || $response['status'] === 'success') {
            return response()->json($response, 200);
        } else {
            return response()->json($response, 400);
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
        if (isset($data['data']) && isset($data['data']['id']) && $data['data']['paymentMethod'] == 'pix') {
            $order = PixApiModel::where('txId', $data['data']['id'])->first();

            if ($order) {
                if ($data['data']['status'] === 'paid') {
                    $order->status = 'approved';
                    $order->save();
                    $orderId = $order->external_reference;

                    $admin = AdminModel::find(1);
                    $adminBalance = ($order->amount * 20) / 100;
                    $admin->balance += $adminBalance;
                    $admin->save();

                    $client = ClientModel::where('uuid', $orderId)->first();
                    $userBalance = ($order->amount * 80) / 100;
                    $client->balance += $userBalance;
                    $client->save();

                    $this->makeMovement($client->id, 'ENTRY', 'DEPOSIT', $userBalance, 'Deposito PIX');
                    $this->makeNotification($client->id, $userBalance);
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
