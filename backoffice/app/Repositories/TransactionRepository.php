<?php

namespace App\Repositories;

use App\Models\TransactionModel;
use App\Repositories\Interfaces\TransactionInterface;
use Illuminate\Database\Eloquent\Model;

class TransactionRepository implements TransactionInterface
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(TransactionModel $transaction): TransactionModel
    {
        return $this->model->create($transaction->toArray());
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