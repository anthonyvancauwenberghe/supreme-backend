<?php

namespace Modules\Settings\Tests;

use Foundation\Abstracts\Tests\TestCase;
use Modules\Settings\Entities\Settings;

class SettingsServiceTest extends TestCase
{
    /**
     * @var Settings[]
     */
    protected $models;

    protected function seedData()
    {
        parent::seedData();
        $this->models = Settings::fromFactory(5)->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSettingsCreation()
    {
        $this->assertNotEmpty($this->models->toArray());
    }
}
