<?php

namespace Modules\Settings\Tests;

use Modules\Auth0\Abstracts\AuthorizedHttpTest;
use Modules\Authorization\Entities\Role;
use Modules\Settings\Contracts\SettingsServiceContract;
use Modules\Settings\Entities\Settings;
use Modules\Settings\Services\SettingsService;
use Modules\Settings\Transformers\SettingsTransformer;

class SettingsHttpTest extends AuthorizedHttpTest
{
    protected $roles = Role::ADMIN;

    /**
     * @var Settings
     */
    protected $model;

    /**
     * @var SettingsService
     */
    protected $service;

    protected function seedData()
    {
        parent::seedData();
        $this->model = factory(Settings::class)->create(['user_id' => $this->getActingUser()->id]);
        $this->service = $this->app->make(SettingsServiceContract::class);
    }

    /**
     * Test retrieving all settings.
     *
     * @return void
     */
    public function testIndexSettings()
    {
        $response = $this->http('GET', '/v1/settings');
        $response->assertStatus(200);

        //TODO assert array rule
        /*
        $this->assertEquals(
            SettingsTransformer::collection($this->service->getByUserId($this->getActingUser()->id))->serialize(),
            $response->decode()
        ); */
    }

    /**
     * Test retrieving a Settings.
     *
     * @return void
     */
    public function testFindSettings()
    {
        $response = $this->http('GET', '/v1/settings/'.$this->model->id);
        $response->assertStatus(200);

        $this->getActingUser()->syncRoles(Role::GUEST);
        $response = $this->http('GET', '/v1/settings/'.$this->model->id);
        $response->assertStatus(403);
    }

    /**
     * Test Settings Deletion.
     *
     * @return void
     */
    public function testDeleteSettings()
    {
        $response = $this->http('DELETE', '/v1/settings/'.$this->model->id);
        $response->assertStatus(204);
    }

    /**
     * Test Settings Creation.
     *
     * @return void
     */
    public function testCreateSettings()
    {
        $model = Settings::fromFactory()->make([]);
        $response = $this->http('POST', '/v1/settings', $model->toArray());
        $response->assertStatus(201);

        //TODO ASSERT RESPONSE CONTAINS ATTRIBUTES
        /*
        $this->assertArrayHasKey('username', $this->decodeHttpResponse($response));
        $this->assertArrayHasKey('password', $this->decodeHttpResponse($response));
        */
    }

    /**
     * Test Updating a Settings.
     *
     * @return void
     */
    public function testUpdateSettings()
    {
        /* Test response for a normal user */
        $response = $this->http('PATCH', '/v1/settings/'.$this->model->id, []);
        $response->assertStatus(200);

        /* Test response for a guest user */
        $this->getActingUser()->syncRoles(Role::GUEST);
        $response = $this->http('PATCH', '/v1/settings/'.$this->model->id, []);
        $response->assertStatus(403);
    }
}
