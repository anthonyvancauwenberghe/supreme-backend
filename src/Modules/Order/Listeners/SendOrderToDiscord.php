<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 14.10.18
 * Time: 19:44.
 */

namespace Modules\Order\Listeners;

use DiscordWebhooks\Client;
use DiscordWebhooks\Embed;
use Foundation\Abstracts\Listeners\QueuedListener;
use Modules\Order\Events\OrderWasCreatedEvent;

class SendOrderToDiscord extends QueuedListener
{
    protected $discord;

    /**
     * SendOrderToDiscord constructor.
     */
    public function __construct()
    {
        $this->discord = new Client(env("DISCORD_WEBHOOK"));;
    }


    /**
     * @param OrderWasCreatedEvent $event
     */
    public function handle(OrderWasCreatedEvent $event): void
    {
        $embed = new Embed();
        $itemName = $event->order->item_id;
        $apiType = $event->order->mobile_api ? "mobile" : "desktop";
        $delay = $event->order->checkout_delay;
        $status = $event->order->status ;
        $message = "Order was placed for item $itemName with the $apiType api and a checkout delay of " . $delay . " seconds";
        $embed->description($message);
        $this->discord
            ->username('Server')
            ->message("New order! Status: $status")
            ->embed($embed)
            ->send();
    }

    /**
     * @param OrderWasCreatedEvent $event
     * @param $exception
     */
    public function failed($event, $exception): void
    {
        throw $exception;
    }
}
