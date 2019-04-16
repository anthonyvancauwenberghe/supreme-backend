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
 * Class MigrationGeneratedEvent
 * @package Foundation\Generator\Events
 */
class MigrationGeneratedEvent extends ResourceGeneratedEvent
{
    public function getTableName()
    {
        return $this->getStubOption("table");
    }

    public function isMongoMigration(){
        return $this->getStubOption("mongo");
    }
}
