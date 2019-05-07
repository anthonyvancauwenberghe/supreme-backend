<?php


namespace Modules\Supreme\Events;


use Foundation\Abstracts\Events\Event;
use Modules\Supreme\Models\SupremeItem;

class SupremeItemOutOfStockEvent extends Event
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