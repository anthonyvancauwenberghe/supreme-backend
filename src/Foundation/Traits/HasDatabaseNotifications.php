<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 14.10.18
 * Time: 18:37.
 */

namespace Foundation\Traits;

trait HasDatabaseNotifications
{
    /**
     * Get the entity's notifications.
     */
    public function notifications()
    {
        if (env('DB_CONNECTION') === 'mongodb') {
            $notificationClass = \Foundation\Models\MongoDatabaseNotification::class;
        } else {
            $notificationClass = \Illuminate\Notifications\DatabaseNotification::class;
        }

        return $this->morphMany($notificationClass, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the entity's read notifications.
     */
    public function readNotifications()
    {
        return $this->notifications()
            ->whereNotNull('read_at');
    }

    /**
     * Get the entity's unread notifications.
     */
    public function unreadNotifications()
    {
        return $this->notifications()
            ->whereNull('read_at');
    }
}
