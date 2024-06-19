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


    /**
     * Undocumented function
     *
     * @param integer $userId
     * @param string $type ('ENTRY' OR 'EXIT)
     * @param string $type_movement ('DEPOSIT', 'WITHDRAWAL', 'TRANSFER')
     * @param float $amount
     * @param string $description
     * @return boolean
     */
    public function create(int $userId, string $type, string $type_movement, float $amount, string $description): string
    {
        $movement = $this->repository->create(new MovementModel([
            "client_id" => $userId,
            'type' => $type,
            'type_movement' => $type_movement,
            'amount' => $amount,
            'description' => $description,
        ]));

        return $movement->uuid;
    }

    public function getAmountSent(int $userId): array
    {
        return $this->repository->getAmountSent($userId);
    }

    public function getLastValueReceived(int $userId): array
    {
        return $this->repository->getLastValueReceived($userId);
    }

    public function getLastFourMovements(int $userId): array
    {
        $movement = $this->repository->getLastFourMovements($userId);
        return $movement;
    }

    public function getLastDays(int $userId, int $days): array
    {
        return $this->repository->getLastDays($userId, $days);
    }
}
