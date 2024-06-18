<?php

namespace App\Services;

use App\Models\NotificationModel;
use App\Repositories\NotificationRepository;

class NotificationService
{
    protected $repository;
    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->repository = $notificationRepository;
    }

    public function create(array $data): bool
    {

        $notification = $this->repository->create(new NotificationModel([
            'client_id' => $data['client_id'],
            'icon' => $data['icon'],
            'title' => $data['data'],
            'body' => $data['body'],
        ]));

        return $notification ? true : false;
    }

    public function getNotificationByUserId(int $userId): array
    {
        return $this->repository->getNotificationByUserId($userId);
    }

    public function readNotification(int $notificationId, int $userId): void
    {
        $this->repository->readNotification($notificationId, $userId);
    }


    public function delete(int $notificationId, int $userId): bool
    {
        return $this->repository->delete($notificationId, $userId);
    }
}
