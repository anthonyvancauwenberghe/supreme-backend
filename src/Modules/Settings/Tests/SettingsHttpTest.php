<?php

namespace Modules\Settings\Tests;

use Modules\Auth0\Abstracts\AuthorizedHttpTest;
use Modules\Authorization\Entities\Role;
use Modules\Settings\Contracts\SettingsServiceContract;
use Modules\Settings\Entities\Settings;
use Modules\Settings\Services\SettingsService;
use Modules\Settings\Transformers\SettingsTransformer;
use Modules\User\Transformers\UserTransformer;

class SettingsHttpTest extends AuthorizedHttpTest
{
    protected $roles = Role::SUBSCRIBER;

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

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserHasSettings()
    {
        $http = $this->http('GET', '/v1/users/me');
        $http->assertStatus(200);
        $httpData = $this->decodeHttpResponse($http);

        $this->assertArrayHasKey('settings', $httpData);
        $this->assertArrayHasKeys([
            'checkout_delay',
            'restock_notifications',
            'wishlist_notifications',
            'drop_notifications',
            'mobile_api',
            'recaptcha_bypass',
            'checkout_delay'
        ], $httpData['settings']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserHasSlowCheckoutDelay()
    {
        $this->getActingUser()->syncRoles(Role::MEMBER);

        $http = $this->http('GET', '/v1/users/me');
        $http->assertStatus(200);
        $httpData = $this->decodeHttpResponse($http);

        $this->assertEquals(config('settings.slow_checkout_delay'),$httpData['settings']['checkout_delay']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSubscriberHasNormalCheckoutDelay()
    {
        $user = $this->getActingUser();
        $user->syncRoles(Role::SUBSCRIBER);

        $delay = $user->settings->checkout_delay;

        $http = $this->http('GET', '/v1/users/me');
        $http->assertStatus(200);
        $httpData = $this->decodeHttpResponse($http);

        $this->assertEquals($delay, $httpData['settings']['checkout_delay']);
    }
}
