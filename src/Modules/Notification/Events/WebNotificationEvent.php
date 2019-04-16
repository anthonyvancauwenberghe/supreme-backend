<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 14.10.18
 * Time: 21:43.
 */

namespace Modules\Notification\Events;

use Illuminate\Notifications\Events\BroadcastNotificationCreated;

class WebNotificationEvent extends BroadcastNotificationCreated
{
    public function broadcastAs()
    {
        return 'notification.created';
    }
}
