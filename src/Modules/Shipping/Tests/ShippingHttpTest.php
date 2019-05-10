<?php

namespace Modules\Shipping\Tests;

use Illuminate\Support\Facades\Event;
use Modules\Auth0\Abstracts\AuthorizedHttpTest;
use Modules\Authorization\Entities\Role;
use Modules\Shipping\Contracts\ShippingServiceContract;
use Modules\Shipping\Dtos\CreateShippingData;
use Modules\Shipping\Entities\Shipping;
use Modules\Shipping\Events\ShippingWasDeletedEvent;
use Modules\Shipping\Services\ShippingService;

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
        $this->service = $this->app->make(ShippingServiceContract::class);
        $this->model = $this->service->create(CreateShippingData::fromFactory(Shipping::class), $this->getActingUser());
        Event::fake();
    }

    /**
     * Test retrieving all shippings.
     *
     * @return void
     */
    public function testIndexShippings()
    {
        $response = $this->http('GET', '/v1/shipping');
        $response->assertStatus(200);

        $data = $response->decode();
        $this->assertNotEmpty($data);
        $this->assertCount(Shipping::where('user_id', $this->getActingUser()->id)->get()->count(), $data);
    }

    /**
     * Test retrieving a Shipping.
     *
     * @return void
     */
    public function testFindShipping()
    {
        $response = $this->http('GET', '/v1/shipping/'.$this->model->id);
        $response->assertStatus(200);
        $this->assertArrayHasKeys(
            [
                "first_name",
                "last_name",
                "full_name",
                "primary",
                "address",
                "address_2",
                "address_3",
                "city",
                "country",
                "postal_code",
                "telephone",
                "email"
            ],
            $data = $response->decode());

        $this->getActingUser()->syncRoles(Role::GUEST);
        $response = $this->http('GET', '/v1/shipping/'.$this->model->id);
        $response->assertStatus(403);
    }

    /**
     * Test Shipping Deletion.
     *
     * @return void
     */
    public function testDeleteShipping()
    {
        $response = $this->http('DELETE', '/v1/shipping/'.$this->model->id);
        $response->assertStatus(204);
        Event::assertDispatched(ShippingWasDeletedEvent::class);
    }

    /**
     * Test Shipping Creation.
     *
     * @return void
     */
    public function testCreateShipping()
    {
        $response = $this->http('POST', '/v1/shipping', Shipping::fromFactory()->raw());
        $response->assertStatus(201);
    }

    /**
     * Test Updating a Shipping.
     *
     * @return void
     */
    public function testUpdateShipping()
    {
        /* Test response for a normal user */
        $response = $this->http('PATCH', '/v1/shipping/'.$this->model->id, []);
        $response->assertStatus(200);

        /* Test response for a guest user */
        $this->getActingUser()->syncRoles(Role::GUEST);
        $response = $this->http('PATCH', '/v1/shipping/'.$this->model->id, []);
        $response->assertStatus(403);
    }

    public function testMakePrimary()
    {
        /* Test response for a normal user */
        $shipping = $this->service->create(CreateShippingData::fromFactory(Shipping::class), $this->getActingUser());
        $response = $this->http('PATCH', '/v1/shipping/' . $shipping->id, ["primary" => true]);
        $response->assertStatus(200);
        $this->assertTrue($response->decode()['primary']);

        $shippingDetails = $this->service->fromUser($this->getActingUser());

        foreach ($shippingDetails as $shipping) {
            if ($shipping->primary) {
                foreach ($shippingDetails as $someShippingDetail) {
                    if ($shipping->id !== $someShippingDetail->id)
                        $this->assertFalse($someShippingDetail->primary);
                }
                $this->assertTrue(true);
                return;
            }
        }

        //THERE IS NO PRIMARY CARD
        $this->assertTrue(false);
    }
}
