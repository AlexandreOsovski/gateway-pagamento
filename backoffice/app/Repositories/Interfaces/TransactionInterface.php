<?php

namespace App\Repositories\Interfaces;

use App\Models\TransactionModel;

interface TransactionInterface
{
    public function create(TransactionModel $transaction): TransactionModel;

    public function getAll(int $userId): array;

    public function getLastFourTransactions(int $userId): array;
}
