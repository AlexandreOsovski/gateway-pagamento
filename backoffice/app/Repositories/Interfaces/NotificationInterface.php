<?php

namespace App\Repositories\Interfaces;

use App\Models\NotificationModel;

interface NotificationInterface
{

    public function getNotificationByUserId(int $userId): ?array;

    public function create(NotificationModel $notification): NotificationModel;

    public function readNotification(int $notificationId, int $userId): void;

    public function delete(int $notificationId, int $userId): bool;
}
