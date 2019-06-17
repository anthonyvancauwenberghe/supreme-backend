<?php

namespace Modules\License\Tests;

use Modules\Auth0\Abstracts\AuthorizedHttpTest;
use Modules\Authorization\Entities\Role;
use Modules\License\Contracts\LicenseServiceContract;
use Modules\License\Entities\License;
use Modules\License\Services\LicenseService;
use Modules\License\Transformers\LicenseTransformer;

class LicenseHttpTest extends AuthorizedHttpTest
{
    protected $roles = Role::ADMIN;

    /**
     * @var License
     */
    protected $model;

    /**
     * @var LicenseService
     */
    protected $service;

    protected function seedData()
    {
        parent::seedData();
        $this->model = factory(License::class)->create(['user_id' => $this->getActingUser()->id]);
        $this->service = $this->app->make(LicenseServiceContract::class);
    }

    /**
     * Test retrieving all licenses.
     *
     * @return void
     */
    public function testIndexLicenses()
    {
        $response = $this->http('GET', '/v1/licenses');
        $response->assertStatus(200);

        //TODO assert array rule
        /*
        $this->assertEquals(
            LicenseTransformer::collection($this->service->getByUserId($this->getActingUser()->id))->serialize(),
            $response->decode()
        ); */
    }
}
