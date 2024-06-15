<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TransferUserToUserInterface;
use App\Models\TransferUserToUserModel;
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


    public function getUserByEmail(string $email): ?TransferUserToUserModel
    {
        $userEmail = $this->model->where("email", $email)->first();
        return $userEmail;
    }


    public function getUserByCode(string $code): ?TransferUserToUserModel
    {
        $userCode = $this->model->where("uuid", $code)->first();
        return $userCode;
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
}