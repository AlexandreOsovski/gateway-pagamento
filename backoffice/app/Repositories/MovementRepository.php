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

    public function getAll(int $userId): array
    {
        return $this->model
            ->where('client_id', $userId)
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
    }

    public function getLastFourMovements(int $userId): array
    {
        return $this->model
            ->where('client_id', $userId)
            ->latest()
            ->take(4)
            ->get()
            ->toArray();
    }
}
