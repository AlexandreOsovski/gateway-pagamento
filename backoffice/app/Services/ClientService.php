<?php

namespace App\Services;

use App\Repositories\ClientRepository;
use App\Models\ClientModel;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class ClientService
{
    protected $repository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->repository = $clientRepository;
    }

    public function create(array $data): bool
    {
        $client = $this->repository->create(new ClientModel([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'document_number' => $data['document_number'],
            'document_type' => $data['document_type'],
            'status' => 'active',
        ]));

        return $client ? true : false;
    }

    public function find(string $id): ?ClientModel
    {
        return $this->repository->find($id);
    }

    public function update(array $client, int $userId): bool
    {
        $clientData = $this->repository->find($userId);


        if (isset($client["old_password"])) {
            $verifyPassword = $this->repository->verifyOldPassword($client["old_password"], $userId);
            if (!$verifyPassword) {
                return false;
            }
        }



        $clientDataUpdate = [
            'avatar' => isset($client['avatar']) ? $this->saveAvatar($client, $clientData->avatar) : $clientData->avatar,
            'name' => $client["name"] ?? $clientData->name,
            'indicator_id' => $client["indicator_id"] ?? $clientData->indicator_id,
            'balance' => $client["balance"] ?? $clientData->balance,
            'balance_usdt' => $client["balance_usdt"] ?? $clientData->balance_usdt,
            'email' => $client["email"] ?? $clientData->email,
            'document_type' => $client["document_type"] ?? $clientData->document_type,
            'document_number' => $client["document_number"] ?? $clientData->document_number,
            'password' => isset($client["password"]) ? bcrypt($client["password"]) : $clientData->password,
            'status' => $client["status"] ?? $clientData->status,
        ];

        $clientUpdated = $this->repository->update($clientDataUpdate, $userId);

        return $clientUpdated ? true : false;
    }

    public function saveAvatar($client, $user_avatar)
    {
        if (isset($client["avatar"])) {
            $avatar = null;
            $requestImage = $client["avatar"];

            if ($requestImage) {
                if ($user_avatar) {
                    Storage::delete($user_avatar);
                }

                $imageName = md5($requestImage->getClientOriginalName() . microtime()) . '.' . $requestImage->getClientOriginalExtension();
                $avatarPath = $requestImage->storeAs('avatars', $imageName, 'public');
                $avatar = '/storage/' . $avatarPath;
            } elseif ($user_avatar) {
                $avatar = $user_avatar;
            }

            return $avatar;
        }
    }
}