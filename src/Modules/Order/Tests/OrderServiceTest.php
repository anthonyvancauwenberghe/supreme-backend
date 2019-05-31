<?php

namespace Modules\Order\Tests;

use Foundation\Abstracts\Tests\TestCase;
use Foundation\Traits\DispatchedEvents;
use Modules\Order\Entities\Order;
use Modules\Order\Events\OrderWasCreatedEvent;
use Modules\Order\Events\OrderWasSuccessfulEvent;

class OrderServiceTest extends TestCase
{
    /**
     * @var Order[]
     */
    protected $models;

    protected function seedData()
    {
        parent::seedData();
        $this->models = Order::fromFactory(5)->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testOrderCreation()
    {
        $this->assertNotEmpty($this->models->toArray());
    }

    public function testOrderNotificationToDiscord(){
        $order = Order::fromFactory()->create();
        event(new OrderWasCreatedEvent($order));

        $this->assertTrue(true);
    }
}
