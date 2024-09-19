<?php

namespace App\Services;

use App\Models\TransactionModel;
use App\Repositories\TransactionRepository;
use Illuminate\Support\Facades\Auth;

class TransactionService
{

    protected $repository;
    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data): bool
    {
        $transaction = $this->repository->create(new TransactionModel([
            "client_id" => Auth::guard("client")->user()->id,
            "method_payment" => $data["method_payment"],
            "amount" => $data["amount"],
            "address" => $data["address"],
            "token" => $data["token"],
            "status" => $data["status"],
            "approved_manual" => $data["approved_manual"],
            "confirm" => $data["confirm"],
        ]));

        return $transaction ? true : false;
    }

    public function getAll(int $userId): array
    {
        return $this->repository->getAll($userId);
    }

    public function getLastFourTransactions(int $userId): array
    {
        return $this->repository->getLastFourTransactions($userId);
    }
}