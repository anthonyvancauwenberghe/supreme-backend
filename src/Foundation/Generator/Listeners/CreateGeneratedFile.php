<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 10.03.19
 * Time: 20:39
 */

namespace Foundation\Generator\Listeners;


use Foundation\Abstracts\Listeners\Listener;
use Foundation\Generator\Contracts\ResourceGenerationContract;
use Foundation\Generator\Generators\FileGenerator;
use Nwidart\Modules\Exceptions\FileAlreadyExistException;

/**
 * Class CreateGeneratedFile
 * @package Foundation\Generator\Listeners
 */
class CreateGeneratedFile extends Listener
{
    /**
     * Handle the event.
     *
     * @param  ResourceGenerationContract $event
     * @throws FileAlreadyExistException
     * @return void
     */
    public function handle(ResourceGenerationContract $event)
    {
        if (file_exists($event->getFilePath()))
            unlink($event->getFilePath());

        (new FileGenerator(
            $event->getFilePath(),
            $event->getStub()->render()
        ))->generate();
    }
}
