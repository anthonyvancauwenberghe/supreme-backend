<?php

namespace Modules\Device\Tests;

use Foundation\Abstracts\Tests\TestCase;
use Modules\Device\Entities\Device;
use Modules\Device\Facades\Firebase;

class DeviceServiceTest extends TestCase
{
    /**
     * @var Device[]
     */
    protected $models;

    protected function seedData()
    {
        parent::seedData();
        $this->models = Device::fromFactory(5)->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDeviceCreation()
    {
        $this->assertNotEmpty($this->models->toArray());
    }

    public function testFirebaseFacade(){
        Firebase::send();
        $this->assertTrue(true);
    }
}
