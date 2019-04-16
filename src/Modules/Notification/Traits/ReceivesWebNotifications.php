<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 27.10.18
 * Time: 15:01.
 */

namespace Modules\Notification\Traits;

trait ReceivesWebNotifications
{
    public function receivesBroadcastNotificationsOn()
    {
        return strtolower(get_short_class_name($this)).'.'.$this->getKey();
    }
}
