<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 04.10.18
 * Time: 16:17.
 */

namespace Modules\Notification\Services;

use Illuminate\Notifications\DatabaseNotification as Notification;
use Modules\Notification\Contracts\NotificationServiceContract;
use Modules\User\Contracts\UserServiceContract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotificationService implements NotificationServiceContract
{
    protected $user;

    /**
     * NotificationService constructor.
     *
     * @param $service
     */
    public function __construct(UserServiceContract $service)
    {
        $this->user = $service;
    }

    public function find($id): ?Notification
    {
        if ($id instanceof Notification) {
            return $id;
        }

        $notification = Notification::find($id);

        if ($notification === null) {
            throw new NotFoundHttpException();
        }

        return $notification;
    }

    public function allNotificationsByUser($user)
    {
        return $this->user->find($user)->notifications;
    }

    public function unreadNotifcationsByUser($user)
    {
        return  $this->user->find($user)->unreadNotifications;
    }

    public function markAsRead($id)
    {
        $this->find($id)->markAsRead();
    }

    public function markAsUnread($id)
    {
        $this->find($id)->markAsUnread();
    }
}
