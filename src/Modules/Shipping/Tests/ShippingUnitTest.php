<?php

namespace Modules\Shipping\Tests;

use Foundation\Abstracts\Tests\TestCase;
use Modules\Shipping\Dtos\UpdateShippingData;
use Modules\Shipping\Entities\Shipping;

class ShippingUnitTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $dto = UpdateShippingData::fromFactory(Shipping::class);

        $this->assertNotEmpty($dto->toArray());
    }
}
