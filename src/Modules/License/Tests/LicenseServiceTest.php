<?php

namespace Modules\License\Tests;

use Foundation\Abstracts\Tests\TestCase;
use Modules\License\Entities\License;

class LicenseServiceTest extends TestCase
{
    /**
     * @var License[]
     */
    protected $models;

    protected function seedData()
    {
        parent::seedData();
        $this->models = License::fromFactory(5)->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLicenseCreation()
    {
        $this->assertNotEmpty($this->models->toArray());
    }
}
