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
 * Class ModelGeneratedEvent
 * @package Foundation\Generator\Events
 */
class ModelGeneratedEvent extends ResourceGeneratedEvent
{
    public function isMongoModel(){
        return $this->getStub()->getOptions()['MONGO'];
    }

    public function includesMigration(){
        return $this->getStub()->getOptions()['MIGRATION'];
    }
}
