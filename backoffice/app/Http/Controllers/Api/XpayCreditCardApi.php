<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderCreditModel;
use App\Models\TokenModel;
use Illuminate\Http\Request;

use App\Services\{
    ClientService,
    KeysApiService
};

use Illuminate\{
    Support\Facades\Validator,
    Support\Facades\Http,
};

class XpayCreditCardApi extends Controller
{
    private string $url;
    private string $authorizationToken;
    private string $apiSecretKey;
    private string $clientId;
    private string $clientSecret;

    private KeysApiService $keysApiService;
    private ClientService $clientService;
    private TokenModel $token;

    private OrderCreditModel $orderCredit;

    public function __construct(KeysApiService $keysApiService, ClientService $clientService)
    {
        $this->clientService = $clientService;
        $this->keysApiService = $keysApiService;
        $this->token = new TokenModel();
        $this->orderCredit = new OrderCreditModel();

        $this->url = 'https://api-br.x-pay.app/v2/';
        $this->authorizationToken = env('AUTHORIZATION_TOKEN');
        $this->apiSecretKey = env('API_SECRET_KEY');

        if (env('APP_ENV') == 'local') {
            $this->clientId = env('API_XPAY_CLIENT_ID_CARD_HML');
            $this->clientSecret = env('API_XPAY_CLIENT_SECRET_CARD_HML');
        } else {
            $this->clientId = env('API_XPAY_CLIENT_ID_CARD_PROD');
            $this->clientSecret = env('API_XPAY_CLIENT_SECRET_CARD_PROD');
        }
    }


    /**
     * Summary of authorization
     * if environment is TEST, HML, LOCAL add "env" => "dev"
     * @return array (access_token)
     */
    public function authorization(): array
    {
        $data = [
            'clientId' => $this->clientId,
            'clientSecret' => $this->clientSecret,
        ];

        $response = Http::withHeaders([
            'authorizationToken' => $this->authorizationToken,
            'content-type' => 'application/json',
        ])->post($this->url . 'token', $data);

        return json_decode($response->body(), true);
    }

    /**
     * Summary of tokenizeCard
     * @param mixed $dataCard (access_token, card_number) if environment is TEST, HML, LOCAL add "env" => "dev" in $dataCard array
     * @return array (number_token)
     */
    public function tokenizeCard($dataCard): array
    {

        $response = Http::withHeaders([
            'authorizationToken' => $this->authorizationToken,
            'content-type' => 'application/json',
        ])->post($this->url . 'creditcard-payment/tokenize', $dataCard);

        return json_decode($response->body(), true);
    }


    /**
     * Summary of makeCharge
     * @param mixed $dataToCharge (
     *      cardHolderName,
     *      number_token,
     *      cvv,
     *      expirityDate,
     *      soft_description,
     *      customerFirstName,
     *      customerLastName,
     *      customerEmail,
     *      customerPhone,
     *      customerAddress,
     *      customerCity,
     *      customerState,
     *      customerZipCode
     * )
     * @return array
     */
    public function makeCharge($dataToCharge): array
    {
        $response = Http::withHeaders([
            'authorizationToken' => $this->authorizationToken,
            'content-type' => 'application/json',
        ])->post($this->url . 'creditcard-payment/charge', $dataToCharge);

        return json_decode($response->body(), true);
    }


    /**
     * Summary of chargePayment
     * @param \Illuminate\Http\Request $request
     * @return array|mixed|\Illuminate\Http\JsonResponse
     */
    public function chargePayment(Request $request)
    {
        if ($request->header('X-API-SECRET') !== $this->apiSecretKey) {
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

        $xpayAuthorization = $this->authorization();
        if (empty($xpayAuthorization)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $rules = [
            'value' => 'required|numeric',
            'orderId' => 'required|string',
            'soft_descriptor' => 'required|string',
            'card' => 'required|array',
            'card.number' => 'required|string',
            'card.name' => 'required|string',
            'card.expirationMonth' => 'required|string',
            'card.expirationYear' => 'required|string',
            'card.cvv' => 'required|string',
            'installments' => 'required|numeric',
            'payerFirstName' => 'required|string',
            'payerFirstLastName' => 'required|string',
            'payerEmail' => 'required|string',
            'payerDocument' => 'required|string',
            'payerDocumentType' => 'required|in:cpf',
            'payerPhone' => 'required|numeric',
            'payerAddress' => 'required|string',
            'payerCity' => 'required|string',
            'payerState' => 'required|string',
            'payerZipCode' => 'required|string',
            'payerIp' => 'required|ip',
            'codeAntiFraud' => 'required|string',
            'items' => 'required|array',
            'items.*.title' => 'required|string',
            'items.*.unitPrice' => 'required|numeric',
            'items.*.quantity' => 'required|numeric',
            'items.*.tangible' => 'required|boolean'
        ];

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $cardData = [
            'access_token' => $xpayAuthorization['access_token'],
            'card_number' => $validatedData['card']['number'],
        ];

        $tokenizeCard = $this->tokenizeCard($cardData);
        if ($tokenizeCard['number_token']) {

            $dataToCharge = [
                "access_token" => $xpayAuthorization['access_token'],
                "amount" => intval($validatedData['value']),
                "installments" => $validatedData['installments'],
                "cardHolderName" => $validatedData['card']['name'],
                "number_token" => $tokenizeCard['number_token'],
                "cvv" => $validatedData['card']['cvv'],
                'expirityDate' => $validatedData['card']['expirationMonth'] . str_replace('20', '', $validatedData['card']['expirationYear']),
                "soft_descriptor" => $validatedData['soft_descriptor'],
                "customerFirstName" => $validatedData['payerFirstName'],
                "customerLastName" => $validatedData['payerLastName'],,
                "customerEmail" => $validatedData['payerEmail'],
                "customerPhone" => $validatedData['payerPhone'],
                "customerAddress" => $validatedData['payerAddress'],
                "customerCity" => $validatedData['payerCity'],
                "customerState" => $validatedData['payerState'],
                "customerZipCode" => $validatedData['payerZipCode'],
                "codeAntiFraud" => $validatedData['codeAntiFraud'],
                "ipAddress" => $validatedData['payerIp'],
                // "env" => "dev"
            ];

            $makeCharge = $this->makeCharge($dataToCharge);
            if ($makeCharge['message'] == 'Payment approved') {

                unset($validatedData['card']);
                $orderCredit = [
                    'client_id' => $keysApi['client_id'],
                    'amount' => $validatedData['value'],
                    'purchase_info' => json_encode($validatedData),
                    'response' => $makeCharge,
                    'external_reference' => $makeCharge['transactionId'],
                    'order_id' => $validatedData['orderId'],
                    'status' => 'paid',
                    'is_approved' => 1
                ];

                $this->saveOrderCredit($orderCredit);
                return $makeCharge;
            }
            return response()->json(['error' => 'Payment was not processed.'], 401);
        }
        return response()->json(['error' => 'Payment was not processed.'], 401);
    }

    /**
     * Summary of cancelCharge
     * @param \Illuminate\Http\Request $dataToCancelCharge
     * @return string
     */
    public function cancelCharge(Request $dataToCancelCharge): string
    {
        if ($dataToCancelCharge->header('X-API-SECRET') !== $this->apiSecretKey) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $authorizationHeader = $dataToCancelCharge->header('Authorization');
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
            'transactionId' => 'required|string',
            'amount' => 'required|numeric'
        ];

        $validator = Validator::make($dataToCancelCharge->all(), $rules);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $data = [
            'transactionId' => $validatedData['transactionId'],
            'amount' => intval($validatedData['amount']),
            'clientId' => $this->clientId,
            'clientSecret' => $this->clientSecret,
        ];

        $response = Http::withHeaders([
            'authorizationToken' => $this->authorizationToken,
            'content-type' => 'application/json',
        ])->post($this->url . 'creditcard-payment/cancel', $data);

        return json_decode($response->body(), true);
    }


    /**
     * Summary of getSummaryTransaction
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function getSummaryTransaction(Request $request)
    {
        if ($request->header('X-API-SECRET') !== $this->apiSecretKey) {
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
            'transactionId' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $data = [
            'transactionId' => $validatedData['transactionId'],
            'clientId' => $this->clientId,
            'clientSecret' => $this->clientSecret,
        ];

        $response = Http::withHeaders([
            'authorizationToken' => $this->authorizationToken,
            'content-type' => 'application/json',
        ])->post($this->url . 'creditcard-payment/transaction-status', $data);

        return json_decode($response->body(), true);
    }

    /**
     * Undocumented function
     *
     * @param array $orderCredit (client_id, amount, purchase_info(is json), response(is json), external_reference, order_id, status('cancelled','paid'), 'is_approved(boolean))
     * @return void
     */
    public function saveOrderCredit($data): void
    {

        $orderCredit = $this->orderCredit;

        $orderCredit->client_id = $data['client_id'];
        $orderCredit->external_reference = $data['external_reference'];
        $orderCredit->order_id = $data['order_id'];
        $orderCredit->amount = $data['amount'];
        $orderCredit->purchase_info = json_encode($data['purchase_info']);
        $orderCredit->response = $data['response'];
        $orderCredit->status = $data['status'];
        $orderCredit->is_approved = $data['is_approved'];
        $orderCredit->save();
    }
}