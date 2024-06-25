<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\{
    TransferUserToUserService
};

class TransactionDetail extends Controller
{
    private $transferUserToUserService;
    public function __construct(TransferUserToUserService $transferUserToUserService)
    {
        $this->transferUserToUserService = $transferUserToUserService;
    }

    public function index(Request $request)
    {
        $uuid = $request->query(str_replace('base64:', '', env('APP_KEY')));
        return view("dashboard.transaction-details", [
                'transaction_detail' => $this->transferUserToUserService->getTransfer($uuid),
                "see_transaction_key" => str_replace('base64:', '', env('APP_KEY'))
            ]

        );
    }
}
