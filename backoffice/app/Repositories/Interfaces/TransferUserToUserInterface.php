<?php

namespace App\Repositories\Interfaces;

use App\Models\TransferUserToUserModel;

interface TransferUserToUserInterface
{
    public function create(TransferUserToUserModel $transferUserToUser): TransferUserToUserModel;

    public function getUserByEmail(string $email): ?TransferUserToUserModel;

    public function getUserByCode(string $code): ?TransferUserToUserModel;

    public function getAll(int $userId): array;

    public function getLastFourTransactions(int $userId): array;
}