<?php

namespace Modules\Shipping\Tests;

use Modules\Auth0\Abstracts\AuthorizedHttpTest;
use Modules\Authorization\Entities\Role;
use Modules\Shipping\Contracts\ShippingServiceContract;
use Modules\Shipping\Entities\Shipping;
use Modules\Shipping\Services\ShippingService;
use Modules\Shipping\Transformers\ShippingTransformer;

class ShippingHttpTest extends AuthorizedHttpTest
{
    protected $roles = Role::ADMIN;

    /**
     * @var Shipping
     */
    protected $model;

    /**
     * @var ShippingService
     */
    protected $service;

    protected function seedData()
    {
        parent::seedData();
        $this->model = factory(Shipping::class)->create(['user_id' => $this->getActingUser()->id]);
        $this->service = $this->app->make(ShippingServiceContract::class);
    }

    /**
     * Test retrieving all shippings.
     *
     * @return void
     */
    public function testIndexShippings()
    {
        $response = $this->http('GET', '/v1/shippings');
        $response->assertStatus(200);

        //TODO assert array rule
        /*
        $this->assertEquals(
            ShippingTransformer::collection($this->service->getByUserId($this->getActingUser()->id))->serialize(),
            $response->decode()
        ); */
    }

    /**
     * Test retrieving a Shipping.
     *
     * @return void
     */
    public function testFindShipping()
    {
        $response = $this->http('GET', '/v1/shippings/'.$this->model->id);
        $response->assertStatus(200);

        $this->getActingUser()->syncRoles(Role::GUEST);
        $response = $this->http('GET', '/v1/shippings/'.$this->model->id);
        $response->assertStatus(403);
    }

    /**
     * Test Shipping Deletion.
     *
     * @return void
     */
    public function testDeleteShipping()
    {
        $response = $this->http('DELETE', '/v1/shippings/'.$this->model->id);
        $response->assertStatus(204);
    }

    /**
     * Test Shipping Creation.
     *
     * @return void
     */
    public function testCreateShipping()
    {
        $model = Shipping::fromFactory()->make([]);
        $response = $this->http('POST', '/v1/shippings', $model->toArray());
        $response->assertStatus(201);

        //TODO ASSERT RESPONSE CONTAINS ATTRIBUTES
        /*
        $this->assertArrayHasKey('username', $this->decodeHttpResponse($response));
        $this->assertArrayHasKey('password', $this->decodeHttpResponse($response));
        */
    }

    /**
     * Test Updating a Shipping.
     *
     * @return void
     */
    public function testUpdateShipping()
    {
        /* Test response for a normal user */
        $response = $this->http('PATCH', '/v1/shippings/'.$this->model->id, []);
        $response->assertStatus(200);

        /* Test response for a guest user */
        $this->getActingUser()->syncRoles(Role::GUEST);
        $response = $this->http('PATCH', '/v1/shippings/'.$this->model->id, []);
        $response->assertStatus(403);
    }
}
