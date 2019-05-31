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
        $style = $event->order->style_id;
        $size = $event->order->size_id;
        $region = $event->order->region;
        $apiType = $event->order->mobile_api ? "mobile" : "desktop";
        $delay = $event->order->checkout_delay;
        $status = $event->order->status ;
       // $message = "Order was placed for item $itemName with the $apiType api and a checkout delay of " . $delay . " seconds";
        $embed
            ->title("Item: $itemName | Style: $style | Size: $size")
            ->footer("Supremewatcher.io",'http://chittagongit.com/download/315864')
            ->field("Api Type", $apiType,true)
            ->field("Checkout Delay", (string) $delay,true)
            ->description("A new order was placed through supremewatcher!");

        $this->discord
            ->username('Server')
            ->message("New $region order! Status: $status")
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
