<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 29.10.18
 * Time: 12:40.
 */

namespace Modules\Notification\Transformers;

use Foundation\Abstracts\Transformers\Transformer;
use Illuminate\Notifications\DatabaseNotification;

class NotificationTransformer extends Transformer
{
    public function transformResource(DatabaseNotification $notification)
    {
        $notificationData = (object) $notification->data;

        return [
            'id'      => $notification->getKey(),
            'title'   => $notificationData->title,
            'message' => $notificationData->message,
            'target'  => $notificationData->target,
            'tag'     => $notificationData->tag,
            'is_read' => isset($notification->read_at) ? true : false,
        ];
    }
}
