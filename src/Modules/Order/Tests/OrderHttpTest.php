<?php

namespace Modules\Order\Tests;

use Modules\Auth0\Abstracts\AuthorizedHttpTest;
use Modules\Authorization\Entities\Role;
use Modules\Order\Contracts\OrderServiceContract;
use Modules\Order\Entities\Order;
use Modules\Order\Services\OrderService;
use Modules\Order\Transformers\OrderTransformer;

class OrderHttpTest extends AuthorizedHttpTest
{
    protected $roles = Role::ADMIN;

    /**
     * @var Order
     */
    protected $model;

    /**
     * @var OrderService
     */
    protected $service;

    protected function seedData()
    {
        parent::seedData();
        $this->model = factory(Order::class)->create(['user_id' => $this->getActingUser()->id]);
        $this->service = $this->app->make(OrderServiceContract::class);
    }

    /**
     * Test retrieving all orders.
     *
     * @return void
     */
    public function testIndexOrders()
    {
        $response = $this->http('GET', '/v1/orders');
        $response->assertStatus(200);
    }

    /**
     * Test Order Creation.
     *
     * @return void
     */
    public function testCreateOrder()
    {
        $model = Order::fromFactory()->make([]);
        $response = $this->http('POST', '/v1/orders', $model->toArray());
        $response->assertStatus(201);
    }
}
