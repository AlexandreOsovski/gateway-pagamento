<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\{
    ClientService,
    KeysApiService,
    MovementService,
    TransactionService,
    TransferUserToUserService,
};

class FinanceController extends Controller
{
    private $movementService;

    // private $transferUserToUserService;
    public function __construct(MovementService $movementService, TransferUserToUserService $transferUserToUserService)
    {
        $this->movementService = $movementService;
        // $this->transferUserToUserService = $transferUserToUserService;
    }
    public function index()
    {
        $client_id = Auth::guard("client")->user()->id;

        return view(
            "dashboard.finance",
            [
                "last_value_received" => $this->movementService->getLastValueReceived($client_id),
                "last_amount_sent" => $this->movementService->getAmountSent($client_id),
                "last_one_days" => $this->movementService->getLastDays($client_id, 1),
                "last_seven_days" => $this->movementService->getLastDays($client_id, 7),
            ]
        );
    }
}