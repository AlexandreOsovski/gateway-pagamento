<?php

namespace App\Repositories;

use App\Models\NotificationModel;
use App\Repositories\Interfaces\NotificationInterface;
use Illuminate\Database\Eloquent\Model;

class NotificationRepository implements NotificationInterface
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getNotificationByUserId(int $userId): ?array
    {
        return $this->model
            ->where('client_id', $userId)
            ->get()
            ->toArray();
    }

    public function create(NotificationModel $notification): NotificationModel
    {
        return $this->model->create($notification->toArray());
    }

    public function readNotification(int $notificationId, int $userId): void
    {
        $this->model->where('id', $notificationId)->where('client_id', $userId)->update(['status' => true]);
    }

    public function delete(int $notificationId, int $userId): bool
    {
        return $this->model->where('id', $notificationId)->where('client_id', $userId)->delete();
    }
}
