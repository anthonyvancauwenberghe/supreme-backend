<?php

namespace Modules\Order\Tests;

use Foundation\Abstracts\Tests\TestCase;
use Foundation\Traits\DispatchedEvents;
use Modules\Order\Contracts\OrderServiceContract;
use Modules\Order\Entities\Order;
use Modules\Order\Events\OrderWasCreatedEvent;
use Modules\Order\Events\OrderWasSuccessfulEvent;
use Modules\Order\Services\OrderService;
use Modules\Order\Transformers\OrderTransformer;
use Modules\User\Contracts\UserServiceContract;
use Modules\User\Services\UserService;

class OrderServiceTest extends TestCase
{
    /**
     * @var Order[]
     */
    protected $models;

    /**
     * @var OrderService
     */
    protected $service;

    protected function seedData()
    {
        parent::seedData();
        $this->service = app()->make(OrderServiceContract::class);
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

    public function testIndex(){
        Order::fromFactory(3)->create(['user_id' => $this->getActingUser()->id]);
      $paginator =  $this->service->fromUser($this->actingUser());
      $data = OrderTransformer::collection($paginator)->jsonSerialize();
        $this->assertNotEmpty($data);
    }
}
