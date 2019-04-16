<?php

namespace Modules\Shipping\Tests;

use Foundation\Abstracts\Tests\TestCase;
use Modules\Shipping\Dtos\CreateShippingData;
use Modules\Shipping\Dtos\UpdateShippingData;
use Modules\Shipping\Entities\Shipping;
use Modules\Shipping\Services\ShippingService;

class ShippingServiceTest extends TestCase
{
    /**
     * @var Shipping[]
     */
    protected $models;

    /**
     * @var ShippingService
     */
    protected $service;

    protected function seedData()
    {
        parent::seedData();
        $this->models = Shipping::fromFactory(5)->create();
        $this->service = $this->app->make(ShippingService::class);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShippingFactory()
    {
        $this->assertNotEmpty($this->models->toArray());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdateShipping()
    {
        $model = $this->models->first();

        $this->service->update($model, new UpdateShippingData(['full_name' => 'hello kitty']));
        $this->assertEquals(Shipping::find($model->id)->full_name, "hello kitty");
        $this->assertEquals(Shipping::find($model->id)->address, $model->address);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateShipping()
    {
        $data = Shipping::fromFactory()->raw();
        $model = $this->service->create(new CreateShippingData($data));
        $this->assertEquals($data["full_name"], $model->full_name);
    }

}
