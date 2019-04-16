<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 10.03.19
 * Time: 20:15
 */

namespace Foundation\Generator\Events;


use Foundation\Generator\Abstracts\ResourceGeneratedEvent;

/**
 * Class CommandGeneratedEvent
 * @package Foundation\Generator\Events
 */
class CommandGeneratedEvent extends ResourceGeneratedEvent
{
    public function getConsoleCommand()
    {
        return $this->getStubOption("command_name");
    }
}
