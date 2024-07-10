<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

use App\Models\{
    KeysApiModel,
    TokenModel,
};
use App\Services\KeysApiService;

class AuthenticateApi extends Controller
{
    public string $keysApi;
    public string $apiSecret;
    public TokenModel $token;

    public $keysApiService;

    public function __construct(KeysApiService $keysApiService)
    {
        $this->keysApiService = $keysApiService;
        $this->token = new TokenModel();


        $this->apiSecret = env('API_SECRET_KEY');
    }

    public function authenticateUser(Request $request)
    {

        if ($request->header('X-API-SECRET') !== $this->apiSecret) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'appId' => 'required|string',
            'appKey' => 'required|string',
        ], [
            'appId.required' => 'The appId field is required',
            'appId.string' => 'The appId field must be a string',
            'appKey.required' => 'The appKey field is required',
            'appKey.string' => 'The appKey field must be a string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $keysApi = $this->keysApiService->getByAppIdAndAppKey($validatedData['appId'],  $validatedData['appKey']);

        if (!$keysApi) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $ip = $request->ip();
        $token = $this->token->generateToken($ip, $validatedData['appId'], $validatedData['appKey']);

        return response()->json(['message' => 'Authentication successful', 'token' => $token, 'success' => true], 200);
    }
}
