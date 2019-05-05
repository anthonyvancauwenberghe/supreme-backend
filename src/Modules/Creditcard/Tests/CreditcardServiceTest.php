<?php

namespace Modules\Creditcard\Tests;

use Foundation\Abstracts\Tests\TestCase;
use Modules\Creditcard\Entities\Creditcard;
use Modules\Lookbook\Jobs\SpringSummer2019LookbookParserJob;

class CreditcardServiceTest extends TestCase
{
    /**
     * @var Creditcard[]
     */
    protected $models;

    protected function seedData()
    {
        parent::seedData();
        $this->models = Creditcard::fromFactory(5)->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreditcardCreation()
    {
        $this->assertNotEmpty($this->models->toArray());
    }
}
