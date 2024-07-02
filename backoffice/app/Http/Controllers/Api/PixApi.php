<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

class Spacefy extends Controller
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
//    private string $webHookVega;

    public function __construct()
    {
        $this->secretKey = "sk_live_LTWpzZcO0T8mkgmVh7JDSYn7nE5BhVAp4JT3UmdVZF";
        $this->path = "https://api-br.x-pay.app";
        $this->version = "v1/";
        $this->url = "{$this->path}/{$this->version}";
        $this->apiSecret = env('API_SECRET_KEY');
    }

    /**
     * Create a transaction credit.
     *
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createTransactionCredit(Request $request): mixed
    {
        if ($request->header('X-API-SECRET') !== $this->apiSecret) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $authorizationHeader = $request->header('Authorization');
        if (!$authorizationHeader) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = str_replace('Bearer ', '', $authorizationHeader);
        $tokenExists = TokenModel::where('token', $token)->exists();

        if (!$tokenExists) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $tokenModel = TokenModel::where('token', $token)->first();

        $keysApi = KeysApiModel::where('appKey', $tokenModel->appKey)->first();

        $rules = [
            'value' => 'required|numeric',
            'orderId' => 'required|string',
            'card' => 'required|array',
            'card.number' => 'required|string',
            'card.name' => 'required|string',
            'card.expirationMonth' => 'required|numeric',
            'card.expirationYear' => 'required|numeric',
            'card.cvv' => 'required|string',
            'installments' => 'required|numeric',
            'payerName' => 'required|string',
            'payerEmail' => 'required|string',
            'payerDocument' => 'required|string',
            'payerDocumentType' => 'required|in:cpf,cnpj',
            'items' => 'required|array',
            'items.*.title' => 'required|string',
            'items.*.unitPrice' => 'required|numeric',
            'items.*.quantity' => 'required|numeric',
            'items.*.tangible' => 'required|boolean'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $documentNumber = $validatedData['payerDocument'];
        $documentNumber = preg_replace('/\D/', '', $documentNumber);

        $amountInCents = intval($validatedData['value'] * 100);

        $transactionData = [
            'amount' => $amountInCents,
            'paymentMethod' => 'credit_card',
            'installments' => $validatedData['installments'],
            'externalRef' => $tokenModel->appKey,
            'card' => [
                'number' => $validatedData['card']['number'],
                'holderName' => $validatedData['card']['name'],
                'expirationMonth' => $validatedData['card']['expirationMonth'],
                'expirationYear' => $validatedData['card']['expirationYear'],
                'cvv' => $validatedData['card']['cvv']
            ],
            'customer' => [
                'name' => $validatedData['payerName'],
                'email' => $validatedData['payerEmail'],
                'document' => [
                    'number' => $documentNumber,
                    'type' => $validatedData['payerDocumentType']
                ],
            ],
            'items' => []
        ];

        foreach ($validatedData['items'] as $item) {
            $unitPriceInCents = intval($item['unitPrice'] * 100);
            $transactionData['items'][] = [
                'title' => $item['title'],
                'unitPrice' => $unitPriceInCents,
                'quantity' => $item['quantity'],
                'tangible' => $item['tangible'],
            ];
        }

        $response = $this->post('/transactions', $transactionData);

        if (
            $response['status'] === 'paid' ||
            $response['status'] === 'processing' ||
            $response['status'] === 'authorized'
        ) {
            $data = [
                "card" => [
                    'firstDigits' => $response['card']['firstDigits'],
                    'lastDigits' => $response['card']['lastDigits'],
                    'brand' => $response['card']['brand'],
                    'holderName' => $response['card']['holderName'],
                    'expirationMonth' => $response['card']['expirationMonth'],
                    'expirationYear' => $response['card']['expirationYear'],
                ],
                "payerName" => $response['customer']['name'],
                "payerDocument" => $response['customer']['document']['number'],
                "value" => $validatedData['value'],
                "txId" => $response['id'],
                "orderId" => $validatedData['orderId'],
                "created_at" => $response['createdAt'],
                "status" => $response['status'],
                'appId' => $tokenModel->appId,
            ];

            OrderCreditModel::create([
                'client_id' => $keysApi->client->id,
                'external_reference' => $response['id'],
                'order_id' => $validatedData['orderId'],
                'amount' => $validatedData['value'],
                'purchase_info' => json_encode($validatedData['items']),
                'response' => json_encode($response),
                'status' => $response['status'],
                'is_approved' => 1,
            ]);

            return response()->json($data, 200);
        } else {
            $data = [
                "card" => [
                    'firstDigits' => $response['card']['firstDigits'],
                    'lastDigits' => $response['card']['lastDigits'],
                    'brand' => $response['card']['brand'],
                    'holderName' => $response['card']['holderName'],
                    'expirationMonth' => $response['card']['expirationMonth'],
                    'expirationYear' => $response['card']['expirationYear'],
                ],
                "payerName" => $response['customer']['name'],
                "payerDocument" => $response['customer']['document']['number'],
                "value" => $validatedData['value'],
                "description" => $response['refusedReason']['description'],
                "txId" => $response['id'],
                "orderId" => $validatedData['orderId'],
                "created_at" => $response['createdAt'],
                "status" => $response['status'],
                'appId' => $tokenModel->appId,
            ];

            if (asset($response['id'])) {
                OrderCreditModel::create([
                    'client_id' => $keysApi->client->id,
                    'external_reference' => $response['id'],
                    'order_id' => $validatedData['orderId'],
                    'amount' => $validatedData['value'],
                    'purchase_info' => json_encode($validatedData['items']),
                    'response' => json_encode($response),
                    'status' => $response['status'],
                    'is_approved' => 1,
                ]);
            }

            return response()->json($data, 400);
        }
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
        if (!$authorizationHeader) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = str_replace('Bearer ', '', $authorizationHeader);
        $tokenExists = TokenModel::where('token', $token)->exists();

        if (!$tokenExists) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $tokenModel = TokenModel::where('token', $token)->first();

        $keysApi = KeysApiModel::where('appKey', $tokenModel->appKey)->first();

        $rules = [
            'value' => 'required|numeric',
            'orderId' => 'required|string',
            'payerName' => 'required|string',
            'payerEmail' => 'required|string',
            'payerDocument' => 'required|string',
            'payerDocumentType' => 'required|string|in:cpf,cnpj',
            'items' => 'required|array',
            'items.*.title' => 'required|string',
            'items.*.unitPrice' => 'required|numeric',
            'items.*.quantity' => 'required|numeric',
            'items.*.tangible' => 'required|boolean'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $documentNumber = $validatedData['payerDocument'];
        $documentNumber = preg_replace('/\D/', '', $documentNumber);

        $amountInCents = intval($validatedData['value'] * 100);

        $transactionData = [
            'amount' => $amountInCents,
            'paymentMethod' => 'pix',
            'externalRef' => $tokenModel->appKey,
            'pix' => [
                'expiresInDays' => 1
            ],
            'customer' => [
                'name' => $validatedData['payerName'],
                'email' => $validatedData['payerEmail'],
                'document' => [
                    'number' => $documentNumber,
                    'type' => $validatedData['payerDocumentType']
                ],
            ],
            'items' => []
        ];

        foreach ($validatedData['items'] as $item) {
            $transactionData['items'][] = [
                'title' => $item['title'],
                'unitPrice' => $item['unitPrice'],
                'quantity' => $item['quantity'],
                'tangible' => $item['tangible'],
            ];
        }

        $response = $this->post('/transactions', $transactionData);

        if ($response['status'] === 'waiting_payment') {
            $pixCopyPaste = $this->generateQrCode($response['pix']['qrcode']);
            $data = [
                "pixCopy" => $response['pix']['qrcode'],
                "pixQrCode" => $pixCopyPaste,
                "payerName" => $response['customer']['name'],
                "payerDocument" => $response['customer']['document']['number'],
                "value" => $validatedData['value'],
                "txId" => $response['id'],
                "orderId" => $validatedData['orderId'],
                "expirationDate" => $response['pix']['expirationDate'],
                "created_at" => $response['createdAt'],
                "status" => 'pending',
                'appId' => $tokenModel->appId,
            ];

            PixCreateJob::dispatch($data, $tokenModel->token)->delay(now()->addSeconds(5))->onQueue('pix-insert');

            return response()->json($data, 200);
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
        $tokenExists = TokenModel::where('token', $token)->exists();

        if (!$tokenExists) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $tokenModel = TokenModel::where('token', $token)->first();

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
        $tokenExists = TokenModel::where('token', $token)->exists();

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
        $tokenExists = TokenModel::where('token', $token)->exists();

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
        $webhookNotification->data = json_encode($data);
        $webhookNotification->save();

        $orderId = null;

        if (isset($data['data']) && isset($data['data']['id']) && $data['data']['paymentMethod'] == 'credit_card') {
            $order = OrderCreditModel::where('external_reference', $data['data']['id'])->first();

            if ($order) {
                $order->status = $data['data']['status'];
                $order->save();

                if ($data['data']['status'] === 'paid') {
                    $order->is_approved = 1;
                    $order->save();

                    $orderId = $order->order_id;

                    $client = ClientModel::where('id', $order->client_id)->first();

                    if (strtolower($client->email) != 'recebimemtosblack@gmail.com') {
                        if (!empty($client->indicator_id) || $client->indicator_id != null) {
                            $admin = AdminModel::find(1);
                            $adminBalance = ($order->amount * 18) / 100;
                            $admin->balance += $adminBalance;
                            $admin->save();
                        } else {
                            $admin = AdminModel::find(1);
                            $adminBalance = ($order->amount * 20) / 100;
                            $admin->balance += $adminBalance;
                            $admin->save();
                        }
                    } else {
                        $admin = AdminModel::find(1);
                        $adminBalance = ($order->amount * 16) / 100;
                        $admin->balance += $adminBalance;
                        $admin->save();
                    }

                    if (!empty($client->indicator_id) || $client->indicator_id != null) {
                        $affiliate = ClientModel::where('id', $order->client->indicator_id)->first();
                        $affiliateBalance = (($order->amount - $adminBalance) * 2) / 100;
                        $affiliate->balance += $affiliateBalance;
                        $affiliate->save();

                        $userBalance = ($order->amount * 80) / 100;

                        $this->entryValues($affiliate->id, 'PIX', 'entry', $affiliateBalance, 'Comissão de Indicação');
                        $this->entryValues($order->client_id, 'PIX', 'entry', $userBalance, 'Venda Cartao de Crédito');
                        $this->payComission($affiliate->id, $order->client_id, $userBalance);
                    } else {
                        $userBalance = ($order->amount * 80) / 100;

                        $this->entryValues($order->client_id, 'PIX', 'entry', $userBalance, 'Venda Cartao de Crédito');
                        $this->payComission($admin->id, $client->id, $adminBalance);
                    }
                }

                $data['data']['Txid'] = $data['data']['id'];
                $data['data']['OrderId'] = $orderId;

                try {
//                    Http::post($this->webHookVega, $data['data']);
                    Log::channel('webhook')->info('Webhook sent successfully');
                } catch (\Exception $e) {
                    Log::channel('webhook')->error('Failed to send webhook: ' . $e->getMessage());
                }
            }
        }

        if (isset($data['data']) && isset($data['data']['id']) && $data['data']['paymentMethod'] == 'pix') {
            $order = PixApiModel::where('order_id', $data['data']['id'])->first();

            if ($order) {
                if ($data['data']['status'] === 'paid') {
                    $order->status = 'approved';
                    $order->is_approved = 1;
                    $order->save();

                    $orderId = $order->external_reference;

                    $keysApi = KeysApiModel::where('appId', $order->appId)->first();
                    if ($keysApi) {

                        $client = ClientModel::where('id', $keysApi->client_id)->first();

                        if (strtolower($client->email) != 'recebimemtosblack@gmail.com') {
                            if (!empty($client->indicator_id) || $client->indicator_id != null) {
                                $admin = AdminModel::find(1);
                                $adminBalance = ($order->amount * 18) / 100;
                                $admin->balance += $adminBalance;
                                $admin->save();
                            } else {
                                $admin = AdminModel::find(1);
                                $adminBalance = ($order->amount * 20) / 100;
                                $admin->balance += $adminBalance;
                                $admin->save();
                            }
                        } else {
                            $admin = AdminModel::find(1);
                            $adminBalance = ($order->amount * 16) / 100;
                            $admin->balance += $adminBalance;
                            $admin->save();
                        }

                        if (!empty($client->indicator_id) || $client->indicator_id != null) {
                            $affiliate = ClientModel::where('id', $order->client->indicator_id)->first();
                            $affiliateBalance = (($order->amount - $adminBalance) * 2) / 100;
                            $affiliate->balance += $affiliateBalance;
                            $affiliate->save();

                            $userBalance = ($order->amount * 80) / 100;

                            $this->entryValues($affiliate->id, 'PIX', 'entry', $affiliateBalance, 'Comissão de Indicação');
                            $this->entryValues($order->client_id, 'PIX', 'entry', $userBalance, 'Venda Cartao de Crédito');
                            $this->payComission($affiliate->id, $order->client_id, $userBalance);
                        } else {
                            $userBalance = ($order->amount * 80) / 100;

                            $this->entryValues($order->client_id, 'PIX', 'entry', $userBalance, 'Venda Cartao de Crédito');
                            $this->payComission($admin->id, $client->id, $adminBalance);
                        }
                    }
                }

                $data['data']['Txid'] = $data['data']['id'];
                $data['data']['OrderId'] = $orderId;

                try {
//                    Http::post($this->webHookVega, $data['data']);
                    Log::channel('webhook')->info('Webhook sent successfully');
                } catch (\Exception $e) {
                    Log::channel('webhook')->error('Failed to send webhook: ' . $e->getMessage());
                }
            }
        }

        return response()->json(['message' => 'Webhook received'], 200);
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
    public function entryValues($client_id, $type, $type_movements, $amount, $description)
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

    public function payComission($client_id, $client_pay_id, $amount)
    {
        $transfer = new TransferUserToUserModel();
        $transfer->client_id = $client_id;
        $transfer->client_pay_id = $client_pay_id;
        $transfer->amount = $amount;
        $transfer->save();
    }


    /**
     * Execute a GET request.
     *
     * @param string $path
     * @param array|null $params
     * @return mixed
     */
    public function get(string $path, ?array $params = null): mixed
    {
        return $this->execute('GET', $path, null, $params);
    }

    /**
     * Execute a POST request.
     *
     * @param string $path
     * @param array|null $body
     * @param array|null $params
     * @return mixed
     */
    public function post(string $path, ?array $body = null, ?array $params = null): mixed
    {
        return $this->execute('POST', $path, $body, $params);
    }

    /**
     * Execute a PUT request.
     *
     * @param string $path
     * @param array|null $body
     * @param array|null $params
     * @return mixed
     */
    public function put(string $path, ?array $body = null, ?array $params = null): mixed
    {
        return $this->execute('PUT', $path, $body, $params);
    }

    /**
     * Execute a DELETE request.
     *
     * @param string $path
     * @param array|null $params
     * @return mixed
     */
    public function delete(string $path, ?array $params = null): mixed
    {
        return $this->execute('DELETE', $path, null, $params);
    }

    /**
     * Execute a request.
     *
     * @param string $method
     * @param string $path
     * @param array|null $body
     * @param array|null $params
     * @return mixed
     */
    public function execute(string $method, string $path, ?array $body = null, ?array $params = null): mixed
    {
        $url = $this->url . $path;
        $headers = [
            'Authorization' => 'Basic ' . base64_encode("{$this->secretKey}:x")
        ];

        $response = Http::withHeaders($headers)->$method($url, $body);

        return $response->json();
    }
}
