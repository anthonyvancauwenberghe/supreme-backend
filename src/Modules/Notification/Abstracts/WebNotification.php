<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 14.10.18
 * Time: 19:50.
 */

namespace Modules\Notification\Abstracts;

use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Notifications\Notification;
use Modules\Notification\Channels\WebBroadcastChannel;
use Modules\Notification\Tags\WebNotificationTag;

abstract class WebNotification extends Notification
{
    protected $model;

    /**
     * WebNotification constructor.
     *
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'title'     => $this->title(),
            'message'   => $this->message(),
            'target'    => get_short_class_name($this->model),
            'target_id' => $this->model->getKey(),
            'tag'       => $this->tag(),
        ];
    }

    /**
     * @param $notifiable
     *
     * @return array
     */
    public function toBroadcast($notifiable)
    {
        $notification = $notifiable->unreadNotifications->last();

        return [
            'id'        => $notification->getKey(),
            'target_id' => $this->model->getKey(),
            'target'    => get_short_class_name($this->model),
            'tag'       => $this->tag(),
            'title'     => $this->title(),
            'message'   => $this->message(),
            'is_read'   => isset($notification->read_at) ? true : false,
        ];
    }

    /**
     * The title for the web notification.
     *
     * @return string
     */
    abstract protected function title(): string;

    /**
     * The message for the web notification.
     *
     * @return string
     */
    abstract protected function message(): string;

    /**
     * The tag for the web notification
     * success | info | warning | danger.
     *
     * @return string
     */
    protected function tag()
    {
        return WebNotificationTag::INFO;
    }

    /**
     * Do not change the order database must be called before broadcast.
     * Otherwise we cannot get the appropriate id to broadcast.
     *
     * @param $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return [
            DatabaseChannel::class,
            WebBroadcastChannel::class,
        ];
    }
}
