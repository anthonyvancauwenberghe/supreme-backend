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
        $itemName = $event->order->item_name;
        $style = $event->order->item_style;
        $size = $event->order->item_size;
        $region = $event->order->region;
        $apiType = $event->order->mobile_api ? "mobile" : "desktop";
        $delay = $event->order->checkout_delay;
        $image = $event->order->item_image;
        $duration = $event->order->checkout_duration ?? "Manual";
        $status = $event->order->status;
       // $message = "Order was placed for item $itemName with the $apiType api and a checkout delay of " . $delay . " seconds";
        $embed
            ->title("Item: $itemName | Style: $style | Size: $size", $event->order->item_url)
            ->thumbnail($image)
            ->footer("Supremewatcher.io",'http://chittagongit.com/download/315864')
            ->field("Api Type", $apiType,true)
            ->field("Checked out in", (string) $duration . " sec",true)
            ->field("Add to cart duration", (string) $event->order->atc_duration,false)
            ->field("checkout loading duration", (string) $event->order->checkout_load_duration ?? "N/A",false)
            ->field("checkout filling duration (includes delay)", (string) $event->order->checkout_fill_duration ?? "N/A",false)
            ->field("checkout response duration", (string) $event->order->checkout_response_duration,false)
            ->field("Checkout Delay", (string) $delay,false)
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
