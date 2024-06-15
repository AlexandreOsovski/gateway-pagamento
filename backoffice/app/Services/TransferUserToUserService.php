<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

use App\Repositories\TransferUserToUserRepository;
use App\Models\TransferUserToUserModel;

class TransferUserToUserService
{
    protected $repository;
    public function __construct(TransferUserToUserRepository $repository)
    {
        $this->repository = $repository;
    }


    public function create(array $data): bool
    {
        $transaction = $this->repository->create(new TransferUserToUserModel([
            "client_id" => Auth::guard('client')->user()->id,
            "client_pay_id" => $data["client_pay_id"],
            "amount" => $data["amount"]
        ]));

        return (bool) $transaction;
    }

    public function getUserByEmail(string $email): ?TransferUserToUserModel
    {
        return $this->repository->getUserByEmail($email);
    }

    public function getUserByCode(string $code): ?TransferUserToUserModel
    {
        return $this->repository->getUserByCode($code);
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