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
        $addtocartDuration = $event->order->atc_duration ?? 0;
        $checkoutLoadDuration = $event->order->checkout_load_duration ?? 0;
        $checkoutFillDuration = $event->order->checkout_fill_duration ?? 0;
        $browserbasedduration = $checkoutLoadDuration + $checkoutFillDuration;
        if ($browserbasedduration === 0)
            $browserbasedduration = $delay;
        $checkoutResponseDuration = $event->order->checkout_response_duration;
        $duration = $addtocartDuration + $checkoutLoadDuration + $checkoutFillDuration + $checkoutResponseDuration;
        $nettoduration = $addtocartDuration + ($browserbasedduration - $delay);
        $status = $event->order->status;
        // $message = "Order was placed for item $itemName with the $apiType api and a checkout delay of " . $delay . " seconds";
        $embed
            ->title("Item: $itemName | Style: $style | Size: $size", $event->order->item_url)
            ->thumbnail($image)
            ->footer("Supremewatcher.io", 'http://chittagongit.com/download/315864')
            ->field("Api Type", $apiType, true)
            ->field("Checkout Delay", (string)$delay . " ms", false)
            ->field("Total checkout time", (string)$duration . " ms", true)
            ->field("Netto checkout time", $addtocartDuration === 0 ? "N/A" : (string)$nettoduration . " ms", true)
            ->field("Add to cart duration", $addtocartDuration === 0 ? "N/A" : (string)$addtocartDuration . " ms", false)
            ->field("Checkout loading duration", (string)$event->order->checkout_load_duration . " ms" ?? "N/A", false)
            ->field("Checkout filling duration (includes part of delay)", (string)$event->order->checkout_fill_duration . " ms" ?? "N/A", false)
            ->field("Load + fill duration (incl delay)", (string)$browserbasedduration . " ms", false)
            ->field("Checkout response duration", (string)$event->order->checkout_response_duration . " ms", false)
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
