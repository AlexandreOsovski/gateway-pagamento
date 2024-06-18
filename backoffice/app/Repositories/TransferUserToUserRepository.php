<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TransferUserToUserInterface;
use App\Models\{
    TransferUserToUserModel,
    ClientModel
};
use Illuminate\Database\Eloquent\Model;

class TransferUserToUserRepository implements TransferUserToUserInterface
{

    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(TransferUserToUserModel $transferUserToUser): TransferUserToUserModel
    {
        return $this->model->create($transferUserToUser->toArray());
    }



    public function getAll(int $userId): array
    {
        return $this->model
            ->where('client_id', $userId)
            ->get()
            ->toArray();
    }


    public function getLastFourTransactions(int $userId): array
    {
        return $this->model
            ->where('client_id', $userId)
            ->latest()
            ->take(4)
            ->get()
            ->toArray();
    }

    public function getLastValueReceived(int $userId): array
    {
        return $this->model
            ->where('client_receive_id', $userId)
            ->latest()
            ->first()
            ->toArray();
    }

    public function getLastAmountSent(int $userId): array
    {
        return $this->model
            ->where('client_id', $userId)
            ->latest()
            ->first()
            ->toArray();
    }

    public function getLastDays(int $userId, int $days): array
    {
        $endDate = now();
        $startDate = now()->subDays($days);

        return $this->model
            ->where('client_id', $userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get()
            ->toArray();
    }
}
