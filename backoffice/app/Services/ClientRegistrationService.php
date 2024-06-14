<?php

namespace App\Services;

use App\Repositories\ClientRepository;
use App\Models\ClientModel;

class ClientRegistrationService
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
}
