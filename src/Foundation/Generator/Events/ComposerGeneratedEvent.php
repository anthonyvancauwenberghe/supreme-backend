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
 * Class ComposerGeneratedEvent
 * @package Foundation\Generator\Events
 */
class ComposerGeneratedEvent extends ResourceGeneratedEvent
{
    public function getAuthorName(){
        return $this->getStubOption("author_name");
    }

    public function getAuthorMail(){
        return $this->getStubOption("author_mail");
    }
}
