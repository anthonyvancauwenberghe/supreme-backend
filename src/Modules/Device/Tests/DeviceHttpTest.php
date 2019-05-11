<?php

namespace Modules\Device\Tests;

use Modules\Auth0\Abstracts\AuthorizedHttpTest;
use Modules\Authorization\Entities\Role;
use Modules\Device\Contracts\DeviceServiceContract;
use Modules\Device\Dtos\CreateDeviceData;
use Modules\Device\Entities\Device;
use Modules\Device\Services\DeviceService;
use Modules\Device\Transformers\DeviceTransformer;

class DeviceHttpTest extends AuthorizedHttpTest
{
    protected $roles = Role::MEMBER;

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
        $this->service = $this->app->make(DeviceServiceContract::class);
        $this->model = $this->service->create(CreateDeviceData::fromFactory(Device::class), $this->getActingUser());
    }

    /**
     * Test retrieving all devices.
     *
     * @return void
     */
    public function testIndexDevices()
    {
        $this->getActingUser()->syncRoles(Role::ADMIN);
        $response = $this->http('GET', '/v1/devices');
        $response->assertStatus(200);

        $this->getActingUser()->syncRoles([Role::SUBSCRIBER, Role::MEMBER]);
        $response = $this->http('GET', '/v1/devices');
        $response->assertStatus(403);
    }

    /**
     * Test retrieving a Device.
     *
     * @return void
     */
    public function testFindDevice()
    {
        $response = $this->http('GET', '/v1/devices/' . $this->model->device_id);
        $response->assertStatus(200);

        $this->getActingUser()->syncRoles(Role::GUEST);
        $response = $this->http('GET', '/v1/devices/' . $this->model->device_id);
        $response->assertStatus(403);
    }

    /**
     * Test Device Deletion.
     *
     * @return void
     */
    public function testDeleteDevice()
    {
        $response = $this->http('DELETE', '/v1/devices/' . $this->model->device_id);
        $response->assertStatus(403);

        $this->getActingUser()->syncRoles(Role::ADMIN);
        $response = $this->http('DELETE', '/v1/devices/' . $this->model->device_id);
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

        $this->assertArrayHasKeys([
            'device_id',
            'device_type',
            'notify_restock',
            'notify_wishlist',
            'notify_drop'
        ], $this->decodeHttpResponse($response));
    }

    /**
     * Test Updating a Device.
     *
     * @return void
     */
    public function testUpdateDevice()
    {
        /* Test response for a normal user */
        $response = $this->http('PATCH', '/v1/devices/' . $this->model->device_id, []);
        $response->assertStatus(200);

        /* Test response for a guest user */
        $this->getActingUser()->syncRoles(Role::GUEST);
        $response = $this->http('PATCH', '/v1/devices/' . $this->model->device_id, []);
        $response->assertStatus(403);
    }
}
