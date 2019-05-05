<?php

namespace Modules\Creditcard\Tests;

use Foundation\Abstracts\Tests\TestCase;
use Modules\Creditcard\Dtos\CreateCreditcardData;
use Modules\Creditcard\Entities\Creditcard;

class CreditcardUnitTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateDto()
    {
        $dto = CreateCreditcardData::fromFactory(Creditcard::class);
        $dto->validate();
        $this->assertTrue(true);
    }
}
