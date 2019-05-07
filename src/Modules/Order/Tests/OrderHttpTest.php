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

        //TODO assert array rule
        /*
        $this->assertEquals(
            OrderTransformer::collection($this->service->getByUserId($this->getActingUser()->id))->serialize(),
            $response->decode()
        ); */
    }

    /**
     * Test retrieving a Order.
     *
     * @return void
     */
    public function testFindOrder()
    {
        $response = $this->http('GET', '/v1/orders/'.$this->model->id);
        $response->assertStatus(200);

        $this->getActingUser()->syncRoles(Role::GUEST);
        $response = $this->http('GET', '/v1/orders/'.$this->model->id);
        $response->assertStatus(403);
    }

    /**
     * Test Order Deletion.
     *
     * @return void
     */
    public function testDeleteOrder()
    {
        $response = $this->http('DELETE', '/v1/orders/'.$this->model->id);
        $response->assertStatus(204);
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

        //TODO ASSERT RESPONSE CONTAINS ATTRIBUTES
        /*
        $this->assertArrayHasKey('username', $this->decodeHttpResponse($response));
        $this->assertArrayHasKey('password', $this->decodeHttpResponse($response));
        */
    }

    /**
     * Test Updating a Order.
     *
     * @return void
     */
    public function testUpdateOrder()
    {
        /* Test response for a normal user */
        $response = $this->http('PATCH', '/v1/orders/'.$this->model->id, []);
        $response->assertStatus(200);

        /* Test response for a guest user */
        $this->getActingUser()->syncRoles(Role::GUEST);
        $response = $this->http('PATCH', '/v1/orders/'.$this->model->id, []);
        $response->assertStatus(403);
    }
}
