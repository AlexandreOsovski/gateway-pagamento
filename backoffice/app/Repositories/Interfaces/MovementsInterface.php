<?php

namespace App\Repositories\Interfaces;

use App\Models\MovementModel;

interface MovementsInterface
{
    public function create(MovementModel $movement): MovementModel;

    public function getAll(int $userId): array;

    public function getLastFourMovements(int $userId): array;
}
