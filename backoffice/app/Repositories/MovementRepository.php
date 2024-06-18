<?php

namespace App\Repositories;

use App\Models\MovementModel;
use App\Repositories\Interfaces\MovementsInterface;
use Illuminate\Database\Eloquent\Model;


class MovementRepository implements MovementsInterface
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(MovementModel $movement): MovementModel
    {
        return $this->model->create($movement->toArray());
    }

    // public function getAllMovements(): array
    // {
    // }


    public function getAmountSent(int $userId): ?array
    {
        $result = $this->model
            ->where('client_id', $userId)
            ->where('type', '=', 'EXIT')
            ->whereIn('type_movement', ['TRANSFER', 'DEPOSIT'])
            ->latest('created_at')
            ->first();

        return $result ? $result->toArray() : [null];
    }

    public function getLastValueReceived(int $userId): ?array
    {
        $result = $this->model
            ->where('client_id', $userId)
            ->where('type', '=', 'ENTRY')
            ->latest('created_at')
            ->first();

        return $result ? $result->toArray() : [null];
    }

    public function getLastFourMovements(int $userId): ?array
    {
        $results = $this->model
            ->where('client_id', $userId)
            ->latest('created_at')
            ->take(4)
            ->get();

        return $results ? $results->toArray() : [null];
    }
    public function getLastDays(int $userId, int $days): array
    {
        $endDate = now();
        $startDate = now()->subDays($days);

        $results = $this->model
            ->where('client_id', $userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest('created_at')
            ->get();

        return $results ? $results->toArray() : [null];
    }
}
