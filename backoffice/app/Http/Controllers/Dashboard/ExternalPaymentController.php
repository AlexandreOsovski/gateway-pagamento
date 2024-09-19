<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ExternalPaymentPixModel;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\Key;

class ExternalPaymentController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->query('vNQt4LbQj3mL935p09jlBRF1t1vqkrCEldSVKIOELzI');
        $decodedToken = JWT::decode($token, new Key(env('APP_JWT_KEY'), 'HS256'));

        $paymentData = ExternalPaymentPixModel::where('client_uuid', $decodedToken->client_uuid)->where('id', $decodedToken->id)->where('external_reference', $decodedToken->external_reference)->where('status', 'pending')->first();
        if($paymentData){
            return view('dashboard.external_payment', ['data' => $paymentData]);
        }else{
            return redirect()->route('dashboard.get');
        }
    }
}
