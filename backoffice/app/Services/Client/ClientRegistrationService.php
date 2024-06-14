<?php

namespace App\Services\Client;

use App\Client\Repositories\ClientRepository;
use App\Models\ClientModel;

class ClientRegistrationService
{
    private $repository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->repository = $clientRepository;
    }

    public function create(array $data): bool
    {
        $client = $this->repository->create(new ClientModel([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'document_number' => $data['document_number'],
            'document_type' => $data['document_type'],
            'status' => 'active',
        ]));

        return $client ? true : false;
    }
}