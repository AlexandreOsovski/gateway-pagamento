<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\{
    ClientService,
    KeysApiService,
    MovementService,
    TransactionService,
    TransferUserToUserService,
};

class DashboardController extends Controller
{
    private $keysApiService;
    private $transactionService;

    private $transferUserToUserService;

    public $movementService;
    public function __construct(KeysApiService $keysApiController, TransactionService $transactionService, TransferUserToUserService $transferUserToUserService, MovementService $movementService)
    {
        $this->keysApiService = $keysApiController;
        $this->transactionService = $transactionService;
        $this->transferUserToUserService = $transferUserToUserService;
        $this->movementService = $movementService;
    }
    public function index()
    {
        $client_id = Auth::guard("client")->user()->id;

        return view(
            "dashboard/home",
            [
                "keysApi" => $this->keysApiService->getLastFourKeysApi($client_id),
                "transactions" =>  $this->movementService->getLastDays($client_id, 4),
                "last_value_received" => $this->movementService->getLastValueReceived($client_id),
                "last_amount_sent" => $this->movementService->getAmountSent($client_id),
                "see_transaction_key" => str_replace('base64:', '', env('APP_KEY'))
            ]
        );
    }
}
