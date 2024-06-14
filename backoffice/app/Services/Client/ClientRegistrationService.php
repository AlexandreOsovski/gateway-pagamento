<?php

namespace App\Services\Client;

use App\Models\ClientModel;

class ClientRegistrationService
{
    private $clientModel;

    public function __construct(ClientModel $clientModel)
    {
        $this->clientModel = $clientModel;
    }

    public function register(array $data): bool
    {
        $client = $this->clientModel->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'document_number' => $data['document_number'],
            'document_type' => $data['document_type'],
            'status' => 'active',
        ]);

        return $client ? true : false;
    }
}
