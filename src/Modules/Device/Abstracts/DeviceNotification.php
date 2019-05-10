<?php


namespace Modules\Device\Abstracts;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

abstract class DeviceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function toArray()
    {
        return [
            "title" => $this->title(),
            "body" => $this->body()
        ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return in_array($notifiable->device_type, ['IOS', 'ANDROID']) ? ['firebase'] : ['broadcast'];
    }

    public abstract function title(): string;

    public abstract function body(): string;
}