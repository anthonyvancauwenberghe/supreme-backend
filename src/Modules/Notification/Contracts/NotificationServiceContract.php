<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 04.10.18
 * Time: 16:15.
 */

namespace Modules\Notification\Contracts;

use Illuminate\Notifications\DatabaseNotification as Notification;

interface NotificationServiceContract
{
    public function find($id): ?Notification;

    public function allNotificationsByUser($user);

    public function unreadNotifcationsByUser($user);

    public function markAsRead($id);

    public function markAsUnread($id);
}
