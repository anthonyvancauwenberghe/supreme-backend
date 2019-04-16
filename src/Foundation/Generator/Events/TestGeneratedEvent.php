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
 * Class TestGeneratedEvent
 * @package Foundation\Generator\Events
 */
class TestGeneratedEvent extends ResourceGeneratedEvent
{
    public function getType(){
        return $this->getStubOption("type");
    }
}
