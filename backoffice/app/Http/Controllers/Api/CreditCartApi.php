<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\{
    Support\Facades\Http,
    Support\Facades\Validator,
    Http\Request
};

use App\Models\{
    OrderCreditModel,
    TokenModel,
    KeysApiModel,
};

use Firebase\JWT\{
    JWT,
    Key,
};


/*
 * Consumo API XPAY
 *
 * */
class CreditCartApi extends Controller
{


    /**
     * URL variable
     *
     * @var string (URL reference api)
     */
    private string $url;

    /**
     * authorization variable
     *
     * @var string (key authorization)
     */
    private string $authorization;

    /**
     * webhook variable
     *
     * @var string (url status payment return)
     */
    private string $webhook;

    /**
     * ENV variable
     *
     * @var string (environment "dev" or "prod")
     */
    private string $env;

    /**
     * apiSecreteKey variable
     *
     * @var string (Fortsec API key)
     */
    private string $apiSecreteKey;

    /**
     * jwtKey variable
     *
     * @var string (get key in .env file)
     */
    private string $jwtKey;

    /**
     * clientId variable
     *
     * @var string (key provided by Xpay)
     */
    private string $clientID;

    /**
     * clientSecrete variable
     *
     * @var string (key provided by Xpay )
     */
    private string $clientSecret;

    /**
     * mcc variable
     *
     * @var integer (number register enterprise provided by Xpay)
     */
    private int $mcc;

    /**
     * orderCredit variable
     *
     * @var OrderCreditModel (Model)
     */
    private OrderCreditModel $orderCredit;

    /**
     * token variable
     *
     * @var TokenModel (Model)
     */
    private TokenModel $token;

    /**
     * keysApi variable
     *
     * @var KeysApiModel (Model)
     */
    private KeysApiModel $keysApi;

    public function __construct()
    {
        $this->url = "https://api-br.x-pay.app/";
        $this->authorization = "1e9fee004b24cad7a7fea4cb9bd36d0c4f1e972ex";
        $this->webhook = 'https://fortsec.com.br/api/v1/webhook/notification/xpay';
        $this->env = 'dev';
        $this->apiSecreteKey = env('API_SECRET_KEY');
        $this->clientID = '37d0fa18-04ec-4d72-8cea-fb8a9997667e';
        $this->clientSecret = 'KqR7z9EhUL9H0AxkdGSA4O103uKHtLqq';
        $this->mcc = 6051;

        $this->orderCredit = new OrderCreditModel();
        $this->token = new TokenModel();
        $this->keysApi = new KeysApiModel();
        $this->jwtKey = env('APP_JWT_KEY');
    }


    /**
     * Creates a credit transaction.
     *
     * @param \Illuminate\Http\Request $request The HTTP request data containing information about the credit transaction to be created.
     *
     * @return string The response from the API server in JSON format, including the details of the created transaction.
     */
    public function createTransactionCredit(Request $request): mixed
    {
        if ($request->header('X-API-SECRET') !== $this->apiSecreteKey) {
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
        $keysApi = $this->keysApi::where('appKey', $tokenModel->appKey)->first();


        if (empty($this->authorization()['access_token']) || !isset($this->authorization()['access_token'])) {
            return response()->json(['error' => 'access key not generated'], 401);
        }
        $accessToken = $this->authorization()['access_token'];


        $rules = [
            'value' => 'required|numeric',
            'orderId' => 'required|string',
            'soft_descriptor' => 'required|string',
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
        $validateData = $validator->validated();
        $data = [
            'access_token' => $accessToken,
            'amount' => intval($validateData['value'] * 100),
            'installments' => $validateData['installments'],
            'soft_descriptor' => $validateData['soft_descriptor'],
        ];

        $responseIntentionPayment = $this->generateIntentionPayment($data);
        if ($responseIntentionPayment['status'] == 200) {
            $data = [
                'nit' => $responseIntentionPayment['data']['payment']['nit'],
                'cardNumber' => $validateData['card']['number'],
                'expirityDate' => $validateData['card']['expirationMonth'] . str_replace('20', '', $validateData['card']['expirationYear']),
                'cvv' => $validateData['card']['cvv'],
                'access_token' => $accessToken
            ];

            $responseChargerPayment = $this->chargerPayment($data);

            if ($responseChargerPayment['status'] == 200 && $responseChargerPayment['data']['message'] == 'Payment approved') {

                $status = 'captured';
                $is_approved = true;
                $statusCode = 200;
            } else {
                $status = 'denied';
                $is_approved = false;
                $statusCode = 422;
            }

            $data = [
                "card" => [
                    'firstDigits' => substr($validateData['card']['number'], 0, 6),
                    'lastDigits' => substr($validateData['card']['number'], strlen($validateData['card']['number']) - 4),
                    'brand' => $this->getCardBrand($validateData['card']['number']),
                    'holderName' => $validateData['card']['name'],
                    'expirationMonth' => $validateData['card']['expirationMonth'],
                    'expirationYear' => $validateData['card']['expirationYear'],
                ],
                "payerName" => $validateData['payerName'],
                "payerDocument" => $validateData['payerDocument'],
                "value" => $validateData['value'],
                "txId" => $responseChargerPayment['data']['transactionId'],
                "orderId" => $validateData['orderId'],
                "created_at" => date('Y-m-d H:i:s'),
                "status" => $status,
                'appId' => $tokenModel->appId,
            ];

            $responseChargerPaymentAndIntentionPayment = [
                'chargerPayment' => $responseChargerPayment,
                'intentionPayment' => $responseIntentionPayment
            ];

            $orderCredit = [
                'client_id' => $keysApi->client_id,
                'external_reference' => $responseChargerPayment['data']['transactionId'],
                'order_id' => $validateData['orderId'],
                'amount' => $validateData['value'],
                'status' => $status,
                'is_approved' => $is_approved,
                'purchase_info' => $validateData,
                'response' => json_encode($responseChargerPaymentAndIntentionPayment),
            ];

            $this->saveOrderCredit($orderCredit);

            return response()->json($data, $statusCode);
        }
        return response()->json($responseIntentionPayment, 422);
    }


    /**
     * prepareAuthorizationData function
     *
     * @return array (returns common data used in several requests)
     */
    private function prepareAuthorizationData(): array
    {
        return [
            'clientId' => $this->clientID,
            'clientSecret' => $this->clientSecret,
            'env' => $this->env,
            'webhook_url' => $this->webhook,
            'mcc' => $this->mcc,
        ];
    }


    /**
     * Performs authorization and returns the access token.
     *
     * @return array Returns an array containing authorization data, including the access token.
     */
    private function authorization(): array
    {
        $data = $this->prepareAuthorizationData();

        $response = Http::withHeaders([
            'authorizationToken' => $this->authorization,
            'Content-Type' => 'application/json',
        ])->post($this->url . 'token', $data);

        return json_decode($response->body(), true);
    }


    /**
     * Generates an intention to pay by credit card.
     *
     * @param array $data The data needed to generate the payment intent.
     *
     * @return array An array containing the status of the request and the data returned by the API.
     */
    private function generateIntentionPayment($data): array
    {
        $data = array_merge(
            $this->prepareAuthorizationData(),
            $data
        );

        $result = Http::withHeaders([
            'authorizationToken' => $this->authorization,
            'Content-Type' => 'application/json'
        ])->post($this->url . 'creditcard-payment/nit', $data);

        if ($result->status() == 200) {
            return [
                'status' => $result->status(),
                'data' => json_decode($result, true)
            ];
        } else {
            return [
                'status' => $result->status(),
                'data' => ''
            ];
        }
    }


    /**
     * chargerPayment function
     *
     * @param array $data (data for execute a charger payment)
     * @return array
     */
    private function chargerPayment($data): array
    {
        $data = array_merge(
            $this->prepareAuthorizationData(),
            $data
        );

        $result = Http::withHeaders([
            'authorizationToken' => $this->authorization,
            'Content-Type' => 'application/json'
        ])->post($this->url . 'creditcard-payment/charge', $data);


        if ($result->status() == 200) {
            return [
                'status' => $result->status(),
                'data' => json_decode($result, true)
            ];
        } else {
            return [
                'status' => $result->status(),
                'data' => ''
            ];
        }
    }



    /**
     * Cancel a credit card payment.
     *
     * @param \Illuminate\Http\Request $request HTTP request data contains information about the payment to be canceled.
     *
     * @return string The response from the API server in JSON format, including payment cancellation details.
     */
    private function cancelChargePayment(Request $request): string
    {
        if ($request->header('X-API-SECRET') !== $this->apiSecreteKey) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $rules = [
            'original_nit' => 'required|string',
            'cardNumber' => 'required|string',
            'expirityDate' => 'required|string',
            'cvv' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $validateData = $validator->validated();
        $data = [
            'original_init' => $validateData['original_nit'],
            'cardNumber' => $validateData['cardNumber'],
            'expirityDate' => $validateData['expirityDate'],
            'cvv' => $validateData['cvv'],
        ];

        $data = array_merge($this->prepareAuthorizationData(), $data);

        $result = Http::withHeaders([
            'authorizationToken' => $this->authorization,
            'Content-Type' => 'application/json',
        ])->post($this->url . 'creditcard-payment/void', $data);

        return response()->json(json_decode($result->body()), $result->status());
    }


    /**
     * Shows transactions carried out within a date range.
     *
     * @param \Illuminate\Http\Request $request The HTTP request data containing the start and end dates of the range.
     *
     * @return string The response from the API server in JSON format, including details of transactions within the specified range.
     */
    private function showTransactions(Request $request): string
    {
        if ($request->header('X-API-SECRET') !== $this->apiSecreteKey) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $rules = [
            'initial_date' => 'required',
            'final_date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => 'Unauthorized'], 422);
        }

        $validateData = $validator->validated();
        $data = [
            'initial_date' => $validateData['initial_date'],
            'final_date' => $validateData['final_date'],
        ];

        $data = array_merge($this->prepareAuthorizationData(), $data);

        $result = Http::withHeaders(['authorizationToken' => $this->authorization])->post($this->url . 'transactions', $data);
        return response()->json(json_decode($result->body()), $result->status());
    }


    /**
     * Saves details of a credit transaction in the database.
     *
     * @param array $data The credit transaction details to be saved in the database.
     *
     * @return bool Returns true if the transaction details were saved successfully, otherwise returns false.
     */
    private function saveOrderCredit($data): bool
    {
        $encodeCreditCardData['purchase_info']['card'] = $this->encryptCreditCard($data['purchase_info']['card']);

        unset($data['purchase_info']['card']);

        $data = array_replace_recursive($data, $encodeCreditCardData);

        $orderCredit = $this->orderCredit;

        $orderCredit->client_id = $data['client_id'];
        $orderCredit->external_reference = $data['external_reference'];
        $orderCredit->order_id = $data['order_id'];
        $orderCredit->amount = $data['amount'];
        $orderCredit->purchase_info = json_encode($data['purchase_info']);
        $orderCredit->response = $data['response'];
        $orderCredit->status = $data['status'];
        $orderCredit->is_approved = $data['is_approved'];

        $result = $orderCredit->save();
        return $result;
    }


    /**
     * Encrypts credit card data using JSON Web Token (JWT).
     *
     * This method encrypts the provided credit card data using the specified JWT key and algorithm.
     *
     * @param array $data The credit card data to be encrypted.
     * @return string The encrypted credit card data as a JWT token.
     */
    private function encryptCreditCard($cardDecrypted): string
    {
        $cardEncrypted = JWT::encode($cardDecrypted, $this->jwtKey, 'HS256');
        return $cardEncrypted;
    }


    /**
     * Decrypt credit card data using JSON Web Token (JWT)
     *
     * This method decrypt the provided credit card data using the specified JWT key and algorithm.
     *
     * @param string $cardEncrypted
     * @return object
     */
    private function decryptCreditCard($cardEncrypted): object
    {
        $cardDecrypted = JWT::decode($cardEncrypted, new Key($this->jwtKey, 'HS256'));
        return $cardDecrypted;
    }

    /**
     * Gets the card brand based on the numbers provided.
     *
     * @param string $cardNumber The card number.
     *
     * @return string The card flag corresponding to the given numbers.
     */
    private function getCardBrand($cardNumber)
    {
        $firstDigit = substr($cardNumber, 0, 1);
        $prefix = substr($cardNumber, 0, 2);

        switch ($firstDigit) {
            case '3':
                return 'american express';
                break;
            case '4':
                return 'visa';
                break;
            case '5':
                return 'mastercard';
                break;
            case '6':
                return 'discover';
                break;
            default:
                switch ($prefix) {
                    case '50':
                    case '51':
                    case '52':
                    case '53':
                    case '54':
                    case '55':
                        return 'mastercard';
                        break;
                    default:
                        return 'Outra bandeira';
                        break;
                }
                break;
        }
    }
}
