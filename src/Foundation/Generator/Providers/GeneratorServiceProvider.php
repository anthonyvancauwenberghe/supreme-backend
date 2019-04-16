<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 09.03.19
 * Time: 18:23.
 */

namespace Foundation\Generator\Providers;

use Foundation\Generator\Commands\AttributeMakeCommand;
use Foundation\Generator\Commands\CommandMakeCommand;
use Foundation\Generator\Commands\ComposerMakeCommand;
use Foundation\Generator\Commands\ControllerMakeCommand;
use Foundation\Generator\Commands\DtoMakeCommand;
use Foundation\Generator\Commands\EventMakeCommand;
use Foundation\Generator\Commands\ExceptionMakeCommand;
use Foundation\Generator\Commands\FactoryMakeCommand;
use Foundation\Generator\Commands\GuardMakeCommand;
use Foundation\Generator\Commands\JobMakeCommand;
use Foundation\Generator\Commands\ListenerMakeCommand;
use Foundation\Generator\Commands\MiddlewareMakeCommand;
use Foundation\Generator\Commands\MigrationMakeCommand;
use Foundation\Generator\Commands\ModelMakeCommand;
use Foundation\Generator\Commands\ModuleMakeCommand;
use Foundation\Generator\Commands\NotificationMakeCommand;
use Foundation\Generator\Commands\PermissionMakeCommand;
use Foundation\Generator\Commands\PolicyMakeCommand;
use Foundation\Generator\Commands\ProviderMakeCommand;
use Foundation\Generator\Commands\RepositoryContractMakeCommand;
use Foundation\Generator\Commands\RepositoryMakeCommand;
use Foundation\Generator\Commands\RequestMakeCommand;
use Foundation\Generator\Commands\RouteMakeCommand;
use Foundation\Generator\Commands\RuleMakeCommand;
use Foundation\Generator\Commands\SeederMakeCommand;
use Foundation\Generator\Commands\ServiceContractMakeCommand;
use Foundation\Generator\Commands\ServiceMakeCommand;
use Foundation\Generator\Commands\TestMakeCommand;
use Foundation\Generator\Commands\TransformerMakeCommand;
use Foundation\Generator\Contracts\ResourceGenerationContract;
use Foundation\Generator\Listeners\CreateGeneratedFile;
use Illuminate\Support\ServiceProvider;

class GeneratorServiceProvider extends ServiceProvider
{
    protected $commands = [
        FactoryMakeCommand::class,
        CommandMakeCommand::class,
        ControllerMakeCommand::class,
        EventMakeCommand::class,
        JobMakeCommand::class,
        ListenerMakeCommand::class,
        MiddlewareMakeCommand::class,
        MigrationMakeCommand::class,
        ProviderMakeCommand::class,
        NotificationMakeCommand::class,
        ModelMakeCommand::class,
        PolicyMakeCommand::class,
        TestMakeCommand::class,
        RuleMakeCommand::class,
        TransformerMakeCommand::class,
        RequestMakeCommand::class,
        SeederMakeCommand::class,
        RuleMakeCommand::class,
        ComposerMakeCommand::class,
        RouteMakeCommand::class,
        ServiceMakeCommand::class,
        ServiceContractMakeCommand::class,
        ModuleMakeCommand::class,
        ExceptionMakeCommand::class,
        PermissionMakeCommand::class,
        AttributeMakeCommand::class,
        DtoMakeCommand::class,
        GuardMakeCommand::class,
        RepositoryMakeCommand::class,
        RepositoryContractMakeCommand::class
    ];

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        \Event::listen(ResourceGenerationContract::class, CreateGeneratedFile::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}
