<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 03.10.18
 * Time: 22:58.
 */

namespace Foundation\Tests;

use Foundation\Abstracts\Tests\TestCase;
use Foundation\Services\BootstrapRegistrarService;

class BootstrappingTest extends TestCase
{
    protected $service;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->service = new BootstrapRegistrarService();
    }

    public function testCacheDelete()
    {
        $this->assertTrue($this->service->cacheExists());
        $this->service->clearCache();
        $this->assertFalse($this->service->cacheExists());
    }

    public function testCaching()
    {
        if ($this->service->cacheExists()) {
            $this->service->clearCache();
        }
        $this->assertFalse($this->service->cacheExists());
        $this->service->recache();
        $this->assertTrue($this->service->cacheExists());
    }

    public function testReadContentsCache()
    {
        $bootstrapData = $this->service->loadBootstrapFromCache();
        $this->assertArrayHasKey('commands', $bootstrapData);
        $this->assertArrayHasKey('routes', $bootstrapData);
        $this->assertArrayHasKey('configs', $bootstrapData);
        $this->assertArrayHasKey('factories', $bootstrapData);
        $this->assertArrayHasKey('migrations', $bootstrapData);
        $this->assertArrayHasKey('seeders', $bootstrapData);
    }

    public function testBootstrapCacheCommand()
    {
        if ($this->service->cacheExists()) {
            $this->service->clearCache();
        }
        $this->assertFalse($this->service->cacheExists());

        \Artisan::call('bootstrap:cache');

        $this->assertTrue($this->service->cacheExists());
    }
}
