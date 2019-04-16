<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 12.03.19
 * Time: 16:39
 */

namespace Foundation\Tests;

use Foundation\Generator\Events\CommandGeneratedEvent;
use Foundation\Generator\Events\ControllerGeneratedEvent;
use Foundation\Generator\Events\EventGeneratedEvent;
use Foundation\Generator\Events\ListenerGeneratedEvent;
use Foundation\Generator\Events\ModelGeneratedEvent;
use Foundation\Generator\Events\ProviderGeneratedEvent;
use Foundation\Generator\Events\ServiceGeneratedEvent;
use Foundation\Generator\Events\TestGeneratedEvent;
use Foundation\Generator\Factories\ModuleFactory;
use Foundation\Traits\DisableRefreshDatabase;
use Foundation\Traits\DispatchedEvents;
use Illuminate\Support\Facades\Event;

/**
 * Class ModuleGeneratorTest
 * @package Foundation\Tests
 */
class ModuleGeneratorTest extends \Foundation\Abstracts\Tests\TestCase
{
    use DisableRefreshDatabase, DispatchedEvents;

    /**
     * @var ModuleFactory
     */
    protected $moduleFactory;

    /**
     * @throws \Nwidart\Modules\Exceptions\FileAlreadyExistException
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->moduleFactory = new ModuleFactory("ARandomTestModule");

        /* Do not remove this line. It prevents the listener that generates the file from executing */
        Event::fake();
    }

    /**
     *
     */
    public function testPiping()
    {
        $this->moduleFactory->addController('TestController');
        $this->moduleFactory->addTest('ServiceTest', 'service');
        $pipeline = $this->moduleFactory->getPipeline();

        $this->assertIsArray($pipeline);
        $this->assertEquals('Controller', $pipeline[0]['name']);
    }

    public function testModuleGeneration()
    {
        $this->moduleFactory->addController('AController');

        $this->moduleFactory->addModel('AModel', true, true);

        $this->moduleFactory->addTest('AServiceTest', 'service');
        $this->moduleFactory->addTest('AHttpTest', 'http');
        $this->moduleFactory->addTest('AUnitTest', 'unit');

        $this->moduleFactory->addCommand('ACommand', 'command:dosomething');

        $this->moduleFactory->addEvent('WasCreatedEvent');
        $this->moduleFactory->addEvent('WasUpdatedEvent');
        $this->moduleFactory->addEvent('WasDeletedEvent');

        $this->moduleFactory->addListener('AListener', 'WasCreatedEvent');

        $this->moduleFactory->addService('AService');

        $this->moduleFactory->addRequest('ARequest');

        $this->moduleFactory->addRoute('v1');

        $this->moduleFactory->addComposer();

        $this->moduleFactory->addMiddleware('AMiddleware');

        $this->moduleFactory->addPolicy('APolicy');

        $this->moduleFactory->addFactory('AModel');

        $this->moduleFactory->addServiceProvider('AServiceProvider');

        $this->moduleFactory->build();

        /* @var ControllerGeneratedEvent $event */
        $event = $this->getFirstDispatchedEvent(ControllerGeneratedEvent::class);
        $this->assertNotNull($event);
        $this->assertEquals("AController", $event->getClassName());

        /* @var ModelGeneratedEvent $event */
        $event = $this->getFirstDispatchedEvent(ModelGeneratedEvent::class);
        Event::assertDispatched(ModelGeneratedEvent::class, 1);
        $this->assertNotNull($event);
        $this->assertEquals("AModel", $event->getClassName());
        $this->assertTrue($event->isMongoModel());
        $this->assertTrue($event->includesMigration());


        /* @var TestGeneratedEvent[] $events */
        $events = $this->getDispatchedEvents(TestGeneratedEvent::class);
        $this->assertNotEmpty($events);

        $this->assertEquals($events[0]->getClassName(), "AServiceTest");
        $this->assertEquals($events[0]->getType(), "service");

        $this->assertEquals($events[1]->getClassName(), "AHttpTest");
        $this->assertEquals($events[1]->getType(), "http");

        $this->assertEquals($events[2]->getClassName(), "AUnitTest");
        $this->assertEquals($events[2]->getType(), "unit");

        Event::assertDispatched(CommandGeneratedEvent::class, 1);

        /* @var CommandGeneratedEvent $event */
        $event = $this->getFirstDispatchedEvent(CommandGeneratedEvent::class);
        $this->assertEquals("ACommand", $event->getClassName());
        $this->assertEquals("command:dosomething", $event->getConsoleCommand());
        $this->assertNotNull($event);

        /* @var EventGeneratedEvent $event */
        Event::assertDispatched(EventGeneratedEvent::class, 3);
        $event = $this->getFirstDispatchedEvent(EventGeneratedEvent::class);
        $this->assertEquals("WasCreatedEvent", $event->getClassName());
        $this->assertNotNull($event);

        /* @var ListenerGeneratedEvent $event */
        $event = $this->getFirstDispatchedEvent(ListenerGeneratedEvent::class);
        $this->assertEquals("AListener", $event->getClassName());
        $this->assertNotNull($event);

        /* @var ServiceGeneratedEvent $event */
        $event = $this->getFirstDispatchedEvent(ServiceGeneratedEvent::class);
        $this->assertEquals("AService", $event->getClassName());
        $this->assertNotNull($event);

        /* @var ProviderGeneratedEvent $event */
        $event = $this->getFirstDispatchedEvent(ProviderGeneratedEvent::class);
        $this->assertEquals("AServiceProvider", $event->getClassName());
        $this->assertNotNull($event);
    }
}
