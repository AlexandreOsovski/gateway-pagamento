<?php

namespace App\Services;
use App\Models\SupportModel;
use App\Repositories\SupportRepository;
use Illuminate\Support\Str;
class SupportService{

    protected $repository;
    public function __construct(SupportRepository $supportRepository)
    {
        $this->repository = $supportRepository;
    }
    public function create(int $userId, string $email, string $phone, string $title, string $body): bool
    {
        $support = $this->repository->create(new SupportModel( [
            'uuid' => Str::uuid(),
            'client_id' => $userId,
            'email' => $email,
            'phone' => $phone,
            'title' => $title,
            'body' => $body
        ]));

        return $support ? true : false;
    }

}
