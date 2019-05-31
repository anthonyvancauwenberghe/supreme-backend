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
use Foundation\Abstracts\Listeners\Listener;

use Modules\Order\Events\OrderWasSuccessfulEvent;

class SendOrderToDiscord extends Listener
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
     * @param OrderWasSuccessfulEvent $event
     */
    public function handle(OrderWasSuccessfulEvent $event): void
    {
        $embed = new Embed();
        $itemName = $event->order->item_id;
        $apiType = $event->order->mobile_api ? "mobile" : "desktop";
        $delay = $event->order->checkout_delay;
        $message = "Item $itemName was bought with the $apiType api and a checkout delay of " . $delay . " seconds";
        $embed->description($message);

        $this->discord
            ->username('Server')
            ->message("New Successful order!")
            ->embed($embed)
            ->send();
    }

    /**
     * @param OrderWasSuccessfulEvent $event
     * @param $exception
     */
    public function failed($event, $exception): void
    {
        throw $exception;
    }
}
