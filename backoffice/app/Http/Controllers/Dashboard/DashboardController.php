<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\{
    ClientService,
    KeysApiService,
    TransactionService,
};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // private $clientService;
    private $keysApiService;
    private $transactionService;
    public function __construct(KeysApiService $keysApiController, TransactionService $transactionService)
    {
        // $this->clientService = $clientService;
        $this->keysApiService = $keysApiController;
        $this->transactionService = $transactionService;
    }
    public function index()
    {
        $client_id = Auth::guard("client")->user()->id;
        return view(
            "dashboard/home",
            [
                "keysApi" => $this->keysApiService->getLastFourKeysApi($client_id),
                "transactions" => $this->transactionService->getLastFourTransactions($client_id),
            ]
        );
    }
}