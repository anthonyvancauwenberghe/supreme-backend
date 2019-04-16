<?php

namespace Foundation\Console;

use Foundation\Services\BootstrapRegistrarService;
use Illuminate\Database\ConnectionResolverInterface as Resolver;
use Illuminate\Database\Eloquent\Model;

class SeedCommand extends \Illuminate\Database\Console\Seeds\SeedCommand
{
    /**
     * The service that registers all module entities.
     *
     * @var BootstrapRegistrarService
     */
    protected $service;

    public function __construct(Resolver $resolver, BootstrapRegistrarService $service)
    {
        parent::__construct($resolver);
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (! $this->confirmToProceed()) {
            return;
        }

        $this->resolver->setDefaultConnection($this->getDatabase());

        Model::unguarded(function () {
            foreach ($this->getSeeders() as $seeder) {
                $seeder = $this->laravel->make($seeder['class']);
                if (! isset($seeder->enabled) || $seeder->enabled) {
                    $seeder->__invoke();
                }
            }
        });

        $this->info('Database seeding completed successfully.');
    }

    protected function getSeeders(): array
    {
        $this->service = $this->laravel->make(BootstrapRegistrarService::class);

        return $this->service->getSeeders() ?? [];
    }
}
