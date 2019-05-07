<?php


namespace Modules\Supreme\Events;


use Foundation\Abstracts\Events\Event;
use Modules\Supreme\Models\SupremeItem;

class SupremeItemReleasedEvent extends Event
{
    public $item;

    /**
     * SupremeItemOutOfStockEvent constructor.
     * @param $item
     */
    public function __construct(SupremeItem $item)
    {
        $this->item = $item;
    }


}