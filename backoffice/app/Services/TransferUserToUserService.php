<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

use App\Repositories\TransferUserToUserRepository;
use App\Models\{
    TransferUserToUserModel,
    ClientModel
};

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
            "amount" => $data["amount"],
            "movement_entry_id" => $data['movement_entry_id'],
            "movement_exit_id" => $data['movement_exit_id'],
        ]));

        return (bool) $transaction;
    }


    public function getAll(int $userId): array
    {
        return $this->repository->getAll($userId);
    }

    public function getTransfer(string $uuid): array
    {
        return $this->repository->getTransfer($uuid);
    }

    public function getLastFourTransactions(int $userId): array
    {
        return $this->repository->getLastFourTransactions($userId);
    }

    public function getLastValueReceived(int $userId): array
    {
        return $this->repository->getLastValueReceived($userId);
    }
    public function getLastAmountSent(int $userId): array
    {
        return $this->repository->getLastAmountSent($userId);
    }

    public function getLastDays(int $days, int $userId): array
    {
        return $this->repository->getLastDays($userId, $days);
    }
}
