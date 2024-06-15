<?php

namespace App\Services;

use App\Models\KeysApiModel;
use App\Repositories\KeysApiRepository;

class KeysApiService
{
    protected $repository;

    public function __construct(KeysApiRepository $keysApiRepository)
    {
        $this->repository = $keysApiRepository;
    }

    public function create(array $data): bool
    {
        $keyApi = $this->repository->create(new KeysApiModel([
            'title' => $data['title'],
        ]));

        return $keyApi ? true : false;
    }

    public function getAll(int $userId)
    {
        $keys = $this->repository->getAll($userId);
        return $keys;
    }

    public function getLastFourKeysApi(int $userId): array
    {
        return $this->repository->getLastFourKeysApi($userId);
    }
}
