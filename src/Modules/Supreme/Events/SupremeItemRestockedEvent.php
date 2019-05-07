<?php


namespace Modules\Supreme\Events;


use Foundation\Abstracts\Events\Event;
use Modules\Supreme\Models\SizeItem;
use Modules\Supreme\Models\SupremeItem;

class SupremeItemRestockedEvent extends Event
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