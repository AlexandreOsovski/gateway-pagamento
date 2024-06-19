<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TransferUserToUserInterface;
use App\Models\{
    TransferUserToUserModel,
    ClientModel
};
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



    public function getAll(int $userId): array
    {
        return $this->model
            ->where('client_id', $userId)
            ->get()
            ->toArray();
    }

    public function getTransfer(string $uuid): array
    {
        return $this->model
            ->where(function ($query) use ($uuid) {
                $query->whereIn('movement_entry_id', [$uuid])
                    ->orWhereIn('movement_exit_id', [$uuid]);
            })
            ->join('movement as entry_movement', 'entry_movement.uuid', '=', 'movement_entry_id')
            ->join('movement as exit_movement', 'exit_movement.uuid', '=', 'movement_exit_id')
            ->join('client AS entry_client', 'entry_client.id', '=', 'entry_movement.client_id')
            ->join('client AS exit_client', 'exit_client.id', '=', 'exit_movement.client_id')
            ->select(
                'entry_client.name AS client_received',
                'entry_movement.type_movement AS entry_type_movement',
                'entry_movement.description AS entry_description',
                'entry_movement.uuid AS entry_transaction_number',
                'exit_movement.type_movement AS exit_type_movement',
                'exit_movement.description AS exit_description',
                'exit_movement.uuid AS exit_transaction_number',
                'exit_client.name AS client_send',
                'entry_movement.amount AS amount',
                'entry_movement.created_at AS transaction_date'
            )
            ->get()
            ->first()
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

    public function getLastValueReceived(int $userId): array
    {
        return $this->model
            ->where('client_receive_id', $userId)
            ->latest()
            ->first()
            ->toArray();
    }

    public function getLastAmountSent(int $userId): array
    {
        return $this->model
            ->where('client_id', $userId)
            ->latest()
            ->first()
            ->toArray();
    }

    public function getLastDays(int $userId, int $days): array
    {
        $endDate = now();
        $startDate = now()->subDays($days);

        return $this->model
            ->where('client_id', $userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get()
            ->toArray();
    }
}
