<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 14.10.18
 * Time: 18:36.
 */

namespace Foundation\Traits;

use Foundation\Models\MongoDatabaseNotification;

trait Notifiable
{
    use \Illuminate\Notifications\Notifiable {
        \Illuminate\Notifications\Notifiable::notifications as baseNotificationsMethod;
    }

    public function notifications()
    {
        if (config('database.default') === 'mongodb') {
            return $this->morphMany(MongoDatabaseNotification::class, 'notifiable')
                ->orderBy('created_at', 'desc');
        }

        return $this->baseNotificationsMethod();
    }
}
