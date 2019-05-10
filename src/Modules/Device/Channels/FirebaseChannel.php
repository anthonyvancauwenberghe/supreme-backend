<?php


namespace Modules\Device\Channels;


use Illuminate\Notifications\Notification;
use Kawankoding\Fcm\Fcm;
use Modules\Device\Entities\Device;
use Modules\Device\Entities\DeviceGroup;

class FirebaseChannel
{
    /**
     * Send the given notification.
     *
     * @param DeviceGroup|Device $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $deviceIds = [];
        if ($notifiable instanceof Device)
            $deviceIds = [$notifiable->device_id];
        elseif ($notifiable instanceof DeviceGroup) {
            foreach ($notifiable->getDevices() as $aNotifiable) {
                $deviceIds = $aNotifiable->device_id;
            }
        } else
            throw new \RuntimeException("Unsupported notifiable given to sender of " . get_class($notification));
        if (method_exists($notification, 'toArray')) {
            (new Fcm())
                ->to($deviceIds)
                ->notification($notification->toArray())
                ->data($notification->toArray())
                ->send();
        }
        throw new \RuntimeException(get_class($notification) . " needs to implement toArray()");
    }
}