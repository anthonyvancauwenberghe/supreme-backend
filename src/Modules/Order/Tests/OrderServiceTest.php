<?php

namespace Modules\Order\Tests;

use Foundation\Abstracts\Tests\TestCase;
use Modules\Order\Entities\Order;

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
}
