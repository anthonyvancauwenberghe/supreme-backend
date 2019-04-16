<?php

namespace Foundation\Generator\Commands;

use Foundation\Generator\Abstracts\AbstractGeneratorCommand;
use Foundation\Generator\Abstracts\ClassGeneratorCommand;
use Foundation\Generator\Events\JobGeneratedEvent;
use Symfony\Component\Console\Input\InputOption;

class JobMakeCommand extends ClassGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapi:make:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new job class for the specified module';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'job';

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Jobs';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = JobGeneratedEvent::class;

    protected function stubOptions(): array
    {
        return [
            'NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $this->getClassName(),
            'SYNC'  => $this->isJobSynchronous()
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function setOptions() :array
    {
        return [
            ['sync', null, InputOption::VALUE_NONE, 'Indicates that job should be synchronous.'],
        ];
    }

    protected function isJobSynchronous(): bool
    {
        return once(function () {
            $option = $this->option('sync');
            if ($option !== null)
                $option = (bool)$option;

            return $option === null ? $this->confirm('Should the job run Synchronously?', false) : $option;
        });
    }

    /**
     * @return string
     */
    protected function stubName(): string
    {
        if ($this->isJobSynchronous()) {
            return 'job.stub';
        }

        return 'job-queued.stub';
    }
}
