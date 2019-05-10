<?php

namespace Modules\User\Tests;

use Foundation\Abstracts\Tests\TestCase;
use Modules\User\Contracts\UserServiceContract;
use Modules\User\Entities\User;
use Modules\User\Services\UserService;

class UserServiceTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var UserService
     */
    protected $service;

    protected function seedData()
    {
        parent::seedData();
        $this->service = $this->app->make(UserServiceContract::class);
        $this->user = $this->service->create(User::fromFactory()->raw());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testNewlyCreatedUserRole()
    {
       $defaultRole = config('role.default');
       $this->assertTrue($this->user->hasRole($defaultRole));
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testNewUserHasSettings()
    {
        $this->assertNotNull($this->user->settings);
    }

}
