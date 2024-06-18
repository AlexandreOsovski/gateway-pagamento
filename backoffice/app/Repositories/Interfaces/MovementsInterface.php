<?php

namespace App\Repositories\Interfaces;

use App\Models\MovementModel;

interface MovementsInterface
{
    public function create(MovementModel $movement): MovementModel;

    // public function getAllMovements(): array;

    public function getLastFourMovements(int $userId): ?array;

    public function getLastDays(int $userId, int $days): ?array;
}
