<?php

namespace App\Services;

use App\Repositories\MovementRepository;
use App\Models\MovementModel;
use Illuminate\Support\Facades\Auth;

class MovementService
{
    protected $repository;

    public function __construct(MovementRepository $clientRepository)
    {
        $this->repository = $clientRepository;
    }

    public function create(array $data): bool
    {
        $movement = $this->repository->create(new MovementModel([
            "client_id" => Auth::guard('client')->user()->id,
            'type' => $data['type'],
            'type_movement' => $data['type_movement'],
            'amount' => $data['amount'],
            'description' => $data['description'],
        ]));

        return $movement ? true : false;
    }

    public function getAll(int $userId): array
    {
        return $this->repository->getAll($userId);
    }

    public function getLastFourMovements(int $userId): array
    {
        $movement = $this->repository->getLastFourMovements($userId);
        return $movement;
    }
}