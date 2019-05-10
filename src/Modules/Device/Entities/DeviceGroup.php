<?php


namespace Modules\Device\Entities;

use Illuminate\Contracts\Notifications\Dispatcher;

class DeviceGroup
{
    protected $devices;

    /**
     * DeviceGroup constructor.
     * @param array $devices
     */
    public function __construct(array $devices = [])
    {
        $this->devices = $devices;
    }

    public function addDevice(Device $device)
    {
        $this->devices[$device->device_id] = $device;
    }

    public function addDevices($devices)
    {
        if ($devices instanceof Device)
            $this->addDevice($devices);
        else {
            if (($devices instanceof DeviceGroup))
                $devices = $devices->getDevices();
            foreach ($devices as $device)
                $this->addDevice($device);
        }
    }

    public function removeDevice(Device $device)
    {
        $this->removeDeviceById($device->device_id);
    }

    public function removeDeviceById($id)
    {
        if (array_key_exists($id, $this->devices))
            unset($this->devices[$id]);
    }

    public function getDevices()
    {
        return $this->getDevices();
    }

    /**
     * Send the given notification.
     *
     * @param mixed $instance
     * @return void
     */
    public function notify($instance)
    {
        app(Dispatcher::class)->send($this->getMobileDevices(), $instance);
        app(Dispatcher::class)->send($this->getDesktopDevices(), $instance);
    }

    /**
     * Send the given notification immediately.
     *
     * @param mixed $instance
     * @param array|null $channels
     * @return void
     */
    public function notifyNow($instance, array $channels = null)
    {
        app(Dispatcher::class)->sendNow($this->getMobileDevices(), $instance, $channels);
        app(Dispatcher::class)->sendNow($this->getDesktopDevices(), $instance, $channels);
    }

    public function getMobileDevices()
    {
        $devices = $this->getIosDevices();
        $devices->addDevices($this->getAndroidDevices());
        return $devices;
    }

    public function getIosDevices()
    {
        return $this->filterByParameterValue("device_type", "IOS");
    }

    public function getAndroidDevices()
    {
        return $this->filterByParameterValue("device_type", "ANDROID");
    }

    public function getDesktopDevices()
    {
        return $this->filterByParameterValue("device_type", "DESKTOP");
    }

    public function getAllowedRestockNotificationDevices()
    {
        return $this->filterByParameterValue("notify_restock", true);
    }

    public function getAllowedWishlistNotificationDevices()
    {
        return $this->filterByParameterValue("notify_wishlist", true);
    }

    public function getAllowedDropNotificationDevices()
    {
        return $this->filterByParameterValue("notify_drop", true);
    }

    protected function filterByParameterValue($parameter, $value)
    {
        $devices = [];
        foreach ($this->devices as $device) {
            if ($device->$parameter === $value)
                $devices[] = $device;
        }
        return new static($devices);
    }
}