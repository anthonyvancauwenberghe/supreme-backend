<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 11.03.19
 * Time: 17:08
 */

namespace Foundation\Traits;

use Foundation\Generator\Abstracts\ResourceGeneratedEvent;
use Foundation\Generator\Contracts\ResourceGenerationContract;
use Illuminate\Support\Facades\Event;

trait DispatchedEvents
{

    /**
     * @param string $class
     * @return ResourceGeneratedEvent[]
     */
    protected function getDispatchedEvents(?string $class): array
    {
        $events = [];
        Event::assertDispatched($class, function ($event) use (&$events) {
            $events[] = $event;
            return true;
        });
        return $events;
    }

    /**
     * @param string $class
     * @return ResourceGenerationContract
     */
    protected function getFirstDispatchedEvent(?string $class): ResourceGenerationContract
    {
        $events = $this->getDispatchedEvents($class);
        if (empty($events))
            return null;
        return $events[0];
    }
}
