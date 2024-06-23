<?php

// namespace App\Http\Controllers\Api;

// use Illuminate\{
//     Support\Facades\Http,
//     Support\Facades\Validator,
//     Http\Request,
//     Support\Facades\Log
// };


// use App\Http\Controllers\{
//     Controller,
//     Services\Email
// };

// use App\Models\{
//     Tokens,
//     MovementModel,
//     ClientModel,
//     AdminModel,
//     TransferUserToUserModel,
//     KeysApi
// };

// use App\Jobs\WebHookJob;
// use App\Jobs\PixCreateJob;

// use Endroid\QrCode\{
//     QrCode,
//     Encoding\Encoding,
//     ErrorCorrectionLevel,
//     Writer\PngWriter
// };

// class PixApi extends Controller
// {
//     # API FORTSEC
//     private int $appId;
//     private string $url;
//     private string $urlSandBox;

//     private string $key;
//     private string $password;
//     private string $passwordFinance;
//     private string $authUrl;
//     private string $tokenApi;
//     private string $authFinance;
//     private string $authFinanceTwo;

//     #CREDENTIALS NEXT PAYMENT
//     private string $clientIdNext;
//     private string $clientSecretNext;
//     private string $accessTokenNext;

//     # API AUTHENTICATE
//     private string $apiSecret;
//     private string $tokenAuth;
//     private string $accessToken;
//     private string $secretWebhook;

//     # URL WEBHOOKS
//     private string $webHookVega;
//     private string $webHookBotft;

//     # MODELS
//     private readonly AdminModel $admin;
//     public readonly ClientModel $client;
//     private readonly Tokens $tokens;
//     private readonly KeysApiMOdel $keysApi;
//     private readonly PixApi $pixApi;
//     private readonly TransferUserToUserModel $transferUser;
//     /**
//      * Constructor
//      */
//     public function __construct()
//     {
//         $this->appId = 115;
//         $this->key = "fortsec";
//         $this->password = "qyr7vLS7egs";
//         $this->passwordFinance = "U6Y5KysnQKv";
//         $this->tokenAuth = "698409";
//         $this->url = "https://apipix.easypay.com.br/api";
//         $this->urlSandBox = "https://apipixhml.easypay.com.br/api";

//         $this->authUrl = $this->url . "/autenticacao/produtos";
//         $this->authFinance = $this->url . "/autenticacao/obter-token";
//         $this->authFinanceTwo = $this->url . "/autenticacao";

//         // $this->webHookVega = "https://pay.vegacheckout.com.br/api/postback/fortsec";
//         // $this->webHookBotft = "https://botft.io/api/postback/fortsec";

//         $this->apiSecret = "c82acdf6-d9fd-4c82-9422-28c51ec333a9";
//         $this->tokenApi = $this->authenticate();
//         // $this->accessToken = $this->authenticateFinance();

//         //Initialize Model
//         $this->admin = new AdminModel();
//         $this->client = new ClientModel();
//         // $this->keysApi = new KeysApi();
//         // $this->tokens = new TokensMO();
//         // $this->pixApi = new PixApiModel();
//         $this->transferUser = new TransferUserToUserModel();
//     }

//     /**
//      * Authenticate in the API
//      *
//      * @return string
//      */
//     public function authenticate(): string
//     {
//         $data = [
//             'appId' => $this->appId,
//             'key' => $this->key,
//             'senha' => $this->password,
//         ];

//         $authResponse = Http::post($this->authUrl, $data);

//         if ($authResponse->successful()) {
//             return $authResponse;
//         } else {
//             return ['error' => $authResponse];
//         }
//     }

//     /**
//      * Authenticate in the API Finance
//      *
//      * @return string
//      */
//     public function authenticateFinance()
//     {
//         $data = [
//             "usuario" => $this->key,
//             "senha" => $this->passwordFinance,
//             "token" => $this->tokenAuth,
//         ];

//         $authResponse = Http::post($this->authFinanceTwo, $data);

//         if ($authResponse->successful()) {
//             $token = $authResponse['token'];
//             return $token;
//         } else {
//             dd($authResponse->body());
//             return ['error' => $authResponse];
//         }
//     }

//     /**
//      * Get a Token Email
//      *
//      * @return void
//      */
//     public function getTokenEmail()
//     {
//         $data = [
//             "usuario" => $this->key,
//             "senha" => $this->passwordFinance,
//         ];

//         $authResponse = Http::post($this->authFinance, $data);

//         if ($authResponse->successful()) {
//             return $authResponse->body();
//         } else {
//             return ['error' => $authResponse->body()];
//         }
//     }

//     /**
//      * Authenticate the user
//      *
//      * @param Request $request
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function authenticateUser(Request $request)
//     {
//         if ($request->header('X-API-SECRET') !== $this->apiSecret) {
//             return response()->json(['error' => 'Unauthorized'], 401);
//         }

//         $validator = Validator::make($request->all(), [
//             'appId' => 'required|string',
//             'appKey' => 'required|string',
//         ], [
//             'appId.required' => 'The appId field is required',
//             'appId.string' => 'The appId field must be a string',
//             'appKey.required' => 'The appKey field is required',
//             'appKey.string' => 'The appKey field must be a string',
//         ]);

//         if ($validator->fails()) {
//             return response()->json(['errors' => $validator->errors()], 422);
//         }

//         $validatedData = $validator->validated();

//         $keysApi = new KeysApi();
//         $keysApi = $keysApi->where('appId', $validatedData['appId'])->where('appKey', $validatedData['appKey'])->first();

//         if (!$keysApi) {
//             return response()->json(['error' => 'Unauthorized'], 401);
//         }

//         $ip = $request->ip();
//         $token = new Tokens();
//         $token = $token->generateToken($ip, $validatedData['appId'], $validatedData['appKey']);

//         return response()->json(['message' => 'Authentication successful', 'token' => $token, 'success' => true], 200);
//     }

//     /**
//      * Generate a PIX
//      *
//      * @param Request $request
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function generatePix(Request $request)
//     {
//         if ($request->header('X-API-SECRET') !== $this->apiSecret) {
//             return response()->json(['error' => 'Unauthorized'], 401);
//         }

//         $authorizationHeader = $request->header('Authorization');
//         if (!$authorizationHeader) {
//             return response()->json(['error' => 'Unauthorized'], 401);
//         }

//         $token = str_replace('Bearer ', '', $authorizationHeader);
//         $tokenExists = Tokens::where('token', $token)->exists();

//         if (!$tokenExists) {
//             return response()->json(['error' => 'Unauthorized'], 401);
//         }

//         $tokenModel = Tokens::where('token', $token)->first();

//         $validator = Validator::make($request->all(), [
//             'value' => 'required|numeric',
//             'orderId' => 'required|string',
//             'payerName' => 'required|string',
//             'payerDocument' => 'required|string',
//             'description' => 'required|string',
//         ], [
//             'value.required' => 'The value field is required',
//             'value.numeric' => 'The value field must be numeric',
//             'orderId.required' => 'The orderId field is required',
//             'orderId.string' => 'The orderId field must be a string',
//             'payerName.required' => 'The payerName field is required',
//             'payerName.string' => 'The payerName field must be a string',
//             'payerDocument.required' => 'The payerDocument field is required',
//             'payerDocument.string' => 'The payerDocument field must be a string',
//             'description.required' => 'The description field is required',
//             'description.string' => 'The description field must be a string',
//         ]);

//         if ($validator->fails()) {
//             return response()->json(['errors' => $validator->errors()], 422);
//         }

//         $validatedData = $validator->validated();

//         if ($this->authenticate()) {
//             $token = $this->tokenApi;
//             $urlPix = $this->url . "/Pix/gerar-qrcode";

//             $data = [
//                 "AppId" => $this->appId,
//                 "valor" => $validatedData['value'],
//                 "nomePagador" => $validatedData['payerName'],
//                 "docPagador" => $validatedData['payerDocument'],
//                 "tempoExpiracao" => 30,
//                 "ordemId" => $validatedData['orderId'],
//                 "descricao" => $validatedData['description'],
//             ];

//             $pixResponse = Http::withHeaders([
//                 'Content-Type' => 'application/json',
//                 'Authorization' => 'Bearer ' . $token,
//                 'AppId' => (string) $this->appId,
//             ])->post($urlPix, $data);

//             if ($pixResponse->successful()) {
//                 $pixCopyPaste = $this->generateQrCode($pixResponse['pixCopiaECola']);
//                 $data = [
//                     "pixCopy" => $pixResponse['pixCopiaECola'],
//                     "pixQrCode" => $pixCopyPaste,
//                     "payerName" => $pixResponse['payer_name'],
//                     "payerDocument" => $pixResponse['payer_doc'],
//                     "value" => $pixResponse['value'],
//                     "txId" => $pixResponse['txid'],
//                     "orderId" => $pixResponse['order_id'],
//                     "expirationDate" => $pixResponse['expired_at'],
//                     "created_at" => $pixResponse['created_at'],
//                     "status" => $pixResponse['status'],
//                     'appId' => $tokenModel->appId,
//                 ];

//                 PixCreateJob::dispatch($data, $tokenModel->token)->delay(now()->addSeconds(5))->onQueue('pix-insert');

//                 return response()->json($data, 200);
//             } else {
//                 $responseBody = $pixResponse->body();
//                 $decodedResponse = json_decode($responseBody, true);

//                 if (json_last_error() !== JSON_ERROR_NONE) {
//                     return response()->json([
//                         'error' => true,
//                         'message' => 'Erro desconhecido',
//                     ], $pixResponse->status());
//                 }

//                 $errorMessage = $decodedResponse['status'] ?? 'Erro desconhecido';

//                 return response()->json([
//                     'error' => true,
//                     'message' => $errorMessage,
//                 ], $pixResponse->status());
//             }
//         } else {
//             return response()->json(['error' => 'Unauthorized'], 401);
//         }
//     }

//     public function sendPix(Request $request)
//     {
//         $this->urlSandBox . '/Pix/transferir';
//     }

//     /**
//      * Get a PIX
//      *
//      * @param Request $request
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function getPix(Request $request)
//     {
//         if ($request->header('X-API-SECRET') !== $this->apiSecret) {
//             return response()->json(['error' => 'Unauthorized'], 401);
//         }

//         $authorizationHeader = $request->header('Authorization');
//         if (!$authorizationHeader) {
//             return response()->json(['error' => 'Unauthorized'], 401);
//         }

//         $token = str_replace('Bearer ', '', $authorizationHeader);
//         $tokenExists = Tokens::where('token', $token)->exists();

//         if (!$tokenExists) {
//             return response()->json(['error' => 'Unauthorized'], 401);
//         }

//         $orderId = $request->query('orderId');
//         if (!$orderId) {
//             return response()->json(['error' => 'orderId is required'], 422);
//         }

//         $response = Http::withHeaders([
//             'Authorization' => 'Bearer ' . $this->accessToken,
//         ])->get($this->url . '/Cliente/obter-pix', [
//             'clienteId' => 131,
//             'orderId' => $orderId,
//         ]);

//         if ($response->successful()) {
//             return response()->json($response->body());
//         } else {
//             return response()->json(['error' => $response->body()], $response->status());
//         }
//     }

//     /**
//      * Get a Balance
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function getBalance()
//     {
//         // return response()->json(['error' => 'Unauthorized'], 401);

//         $response = Http::withHeaders([
//             'Authorization' => 'Bearer ' . $this->accessToken,
//         ])->get($this->url . '/Cliente/saldo', [
//             'clienteId' => 131,
//         ]);

//         if ($response->successful()) {
//             return response()->json(["balance" => $response['saldo']]);
//         } else {
//             return response()->json(['error' => $response->body()], $response->status());
//         }
//     }

//     /**
//      * Webhook
//      *
//      * @param Request $request
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function webHook(Request $request)
//     {

//         $expectedHash = '7zL5R>,/Q)h]xv34>^MBQP waC>jr2B7w%G$zScA03~?](Bj2[8MaI[r:K/(=hQBW(#, [4IxR.Z1)rF9-Z(GI5EI+JqG\'W%W*g?6Cu2b?=CE>VRNnIE/aNPT-U;$djP';

//         if ($request->header('KWhook') !== $expectedHash) {
//             return response()->json(['message' => 'Forbidden'], 403);
//         }

//         $data = $request->all();

//         $data['PaymentMethod'] = "pix";

//         $webhookNotification = new WebhookNotification();
//         if (isset($data['event'])) {
//             $webhookNotification->event = $data['event'];
//         } else {
//             $webhookNotification->event = "update_payment";
//         }
//         $webhookNotification->data = json_encode($data);
//         $webhookNotification->save();

//         $verifyExist = DepositPix::where('order_id', $data['OrderId'])->where('status', 'pending')->first();

//         if ($verifyExist && $data['Status'] == "received") {
//             $verifyExist->status = "approved";
//             $verifyExist->save();

//             $client = Client::where('id', $verifyExist->client_id)->first();

//             if (!empty($client->indicator_id)) {
//                 $affiliate = Client::where('id', $client->indicator_id)->first();
//                 $admin = $this->admin::find(1);

//                 $adminBalance = ($verifyExist->amount * 20) / 100;
//                 $admin->balance += $adminBalance;
//                 $admin->save();

//                 $this->payComission($admin->id, $client->id, $adminBalance);

//                 $affiliateBalance = (($verifyExist->amount - $adminBalance) * 5) / 100;
//                 $affiliate->balance += $affiliateBalance;
//                 $affiliate->save();

//                 $this->entryValues($affiliate->id, 'PIX - Comissão', 'indication', $affiliateBalance, 'Comissão de Indicação  - ' . $client->name);
//                 $this->payComission($affiliate->id, $client->id, $affiliateBalance);

//                 $userBalance = $verifyExist->amount - ($adminBalance + $affiliateBalance);
//                 $client->balance += $userBalance;
//                 $client->save();

//                 $this->entryValues($verifyExist->client_id, 'PIX - Depósito', 'entry', $userBalance, 'Depósito PIX');
//             } else {

//                 if (strtolower($client->email) != 'recebimemtosblack@gmail.com') {
//                     $admin = $this->admin::find(1);
//                     $adminBalance = ($verifyExist->amount * 20) / 100;
//                     $admin->balance += $adminBalance;
//                     $admin->save();
//                 } else {
//                     $admin = $this->admin::find(1);
//                     $adminBalance = ($verifyExist->amount * 16) / 100;
//                     $admin->balance += $adminBalance;
//                     $admin->save();
//                 }

//                 $this->payComission($admin->id, $client->id, $adminBalance);

//                 $userBalance = $verifyExist->amount - $adminBalance;
//                 $client->balance += $userBalance;
//                 $client->save();

//                 $this->entryValues($verifyExist->client_id, 'PIX - Depósito', 'entry', $userBalance, 'Depósito PIX');
//             }

//             $emailData = [
//                 'value' => $data['Valor'],
//                 'type' => "PIX",
//                 'name' => $data['NomePagador'],
//                 'status' => $data['Status'],
//             ];

//             Email::sendEmailPix($emailData, $client->email);
//         }

//         $verifyApiExist = $this->pixApi::where('order_id', $data['OrderId'])->where('status', 'pending')->first();

//         if ($verifyApiExist && $data['Status'] == "received") {

//             $keys_api = $this->keysApi::where('appId', $verifyApiExist->appId)->first();

//             if ($keys_api) {

//                 $client = Client::where('id', $keys_api->client_id)->first();

//                 if (strtolower($client->email) != 'recebimemtosblack@gmail.com') {
//                     if (!empty($client->indicator_id) || $client->indicator_id != null) {
//                         $admin = $this->admin::find(1);
//                         $adminBalance = ($verifyApiExist->amount * 18) / 100;
//                         $admin->balance += $adminBalance;
//                         $admin->save();
//                     } else {
//                         $admin = $this->admin::find(1);
//                         $adminBalance = ($verifyApiExist->amount * 20) / 100;
//                         $admin->balance += $adminBalance;
//                         $admin->save();
//                     }
//                 } else {
//                     $admin = $this->admin::find(1);
//                     $adminBalance = ($verifyApiExist->amount * 16) / 100;
//                     $admin->balance += $adminBalance;
//                     $admin->save();
//                 }


//                 if (!empty($client->indicator_id) || $client->indicator_id != null) {
//                     $affiliate = $this->client::where('id', $keys_api->client->indicator_id)->first();
//                     $affiliateBalance = (($verifyApiExist->amount - $adminBalance) * 2) / 100;
//                     $affiliate->balance += $affiliateBalance;
//                     $affiliate->save();

//                     $userBalance = ($verifyApiExist->amount * 80) / 100;

//                     $this->entryValues($affiliate->id, 'PIX', 'entry', $affiliateBalance, 'Comissão de Indicação');
//                     $this->entryValues($keys_api->client_id, 'PIX', 'entry', $userBalance, 'Venda PIX');
//                     $this->payComission($affiliate->id, $keys_api->client_id, $userBalance);
//                 } else {
//                     $userBalance = ($verifyApiExist->amount * 80) / 100;

//                     $this->entryValues($keys_api->client_id, 'PIX', 'entry', $userBalance, 'Venda PIX');
//                     $this->payComission($admin->id, $client->id, $adminBalance);
//                 }

//                 $keys_api->client->balance += $userBalance;
//                 $keys_api->client->save();

//                 $verifyApiExist->status = "approved";
//                 $verifyApiExist->save();
//             }
//         }

//         try {
//             Http::post($this->webHookVega, $data);
//             Log::channel('webhook')->info('Webhook sent successfully');
//         } catch (\Exception $e) {
//             Log::channel('webhook')->error('Failed to send webhook: ' . $e->getMessage());
//         }

//         // try {
//         //     Http::post($this->webHookBotft, $data);
//         //     Log::channel('webhook')->info('Webhook sent successfully');
//         // } catch (\Exception $e) {
//         //     Log::channel('webhook')->error('Failed to send webhook: ' . $e->getMessage());
//         // }

//         return response()->json(['message' => 'Webhook received'], 200);
//     }

//     /**
//      * Generate a QR Code
//      *
//      * @param string $pixCopyPaste
//      * @return string
//      */
//     public function generateQrCode($pixCopyPaste)
//     {
//         $qrCode = new QrCode($pixCopyPaste);
//         $qrCode->setEncoding(new Encoding('UTF-8'))
//             ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
//             ->setSize(300)
//             ->setMargin(10);

//         $writer = new PngWriter();

//         $qrCodeOutput = $writer->write($qrCode);
//         $qrCodeDataUri = $qrCodeOutput->getDataUri();

//         $base64 = substr($qrCodeDataUri, strpos($qrCodeDataUri, ",") + 1);

//         return $base64;
//     }

//     /**
//      * Register a financial movement.
//      *
//      * @param int $client_id The ID of the client associated with the movement.
//      * @param string $type The type of financial movement (for example, 'entry' or 'out').
//      * @param string $type_movements The specific type of movement (e.g. 'Deposit' or 'Commission').
//      * @param float $amount The value of the financial movement.
//      * @param string $description A description of the financial movement.
//      * @return null
//      */
//     public function entryValues($client_id, $type, $type_movements, $amount, $description)
//     {
//         $movement = new Movement();
//         $movement->client_id = $client_id;
//         $movement->type = $type;
//         $movement->type_movement = $type_movements;
//         $movement->amount = $amount;
//         $movement->description = $description;
//         $movement->save();
//     }

//     /**
//      * Records a transfer of value from one user to another.
//      *
//      * @param int $client_id The ID of the customer making the payment.
//      * @param int $client_pay_id The ID of the customer receiving the payment.
//      * @param float $amount The transfer amount.
//      * @return void
//      */

//     public function payComission($client_id, $client_pay_id, $amount)
//     {
//         $transfer = $this->transferUser;
//         $transfer->client_id = $client_id;
//         $transfer->client_pay_id = $client_pay_id;
//         $transfer->amount = $amount;
//         $transfer->save();
//     }
// }