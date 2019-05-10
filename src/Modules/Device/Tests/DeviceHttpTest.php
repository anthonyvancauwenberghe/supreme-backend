<?php

namespace Modules\Device\Tests;

use Modules\Auth0\Abstracts\AuthorizedHttpTest;
use Modules\Authorization\Entities\Role;
use Modules\Device\Contracts\DeviceServiceContract;
use Modules\Device\Entities\Device;
use Modules\Device\Services\DeviceService;
use Modules\Device\Transformers\DeviceTransformer;

class DeviceHttpTest extends AuthorizedHttpTest
{
    protected $roles = Role::ADMIN;

    /**
     * @var Device
     */
    protected $model;

    /**
     * @var DeviceService
     */
    protected $service;

    protected function seedData()
    {
        parent::seedData();
        $this->model = factory(Device::class)->create(['user_id' => $this->getActingUser()->id]);
        $this->service = $this->app->make(DeviceServiceContract::class);
    }

    /**
     * Test retrieving all devices.
     *
     * @return void
     */
    public function testIndexDevices()
    {
        $response = $this->http('GET', '/v1/devices');
        $response->assertStatus(200);

        //TODO assert array rule
        /*
        $this->assertEquals(
            DeviceTransformer::collection($this->service->getByUserId($this->getActingUser()->id))->serialize(),
            $response->decode()
        ); */
    }

    /**
     * Test retrieving a Device.
     *
     * @return void
     */
    public function testFindDevice()
    {
        $response = $this->http('GET', '/v1/devices/'.$this->model->id);
        $response->assertStatus(200);

        $this->getActingUser()->syncRoles(Role::GUEST);
        $response = $this->http('GET', '/v1/devices/'.$this->model->id);
        $response->assertStatus(403);
    }

    /**
     * Test Device Deletion.
     *
     * @return void
     */
    public function testDeleteDevice()
    {
        $response = $this->http('DELETE', '/v1/devices/'.$this->model->id);
        $response->assertStatus(204);
    }

    /**
     * Test Device Creation.
     *
     * @return void
     */
    public function testCreateDevice()
    {
        $model = Device::fromFactory()->make([]);
        $response = $this->http('POST', '/v1/devices', $model->toArray());
        $response->assertStatus(201);

        //TODO ASSERT RESPONSE CONTAINS ATTRIBUTES
        /*
        $this->assertArrayHasKey('username', $this->decodeHttpResponse($response));
        $this->assertArrayHasKey('password', $this->decodeHttpResponse($response));
        */
    }

    /**
     * Test Updating a Device.
     *
     * @return void
     */
    public function testUpdateDevice()
    {
        /* Test response for a normal user */
        $response = $this->http('PATCH', '/v1/devices/'.$this->model->id, []);
        $response->assertStatus(200);

        /* Test response for a guest user */
        $this->getActingUser()->syncRoles(Role::GUEST);
        $response = $this->http('PATCH', '/v1/devices/'.$this->model->id, []);
        $response->assertStatus(403);
    }
}
