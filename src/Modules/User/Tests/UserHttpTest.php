<?php

namespace Modules\User\Tests;

use Modules\Auth0\Abstracts\AuthorizedHttpTest;
use Modules\Authorization\Entities\Role;
use Modules\User\Contracts\UserServiceContract;
use Modules\User\Entities\User;
use Modules\User\Transformers\UserTransformer;

class UserHttpTest extends AuthorizedHttpTest
{
    protected $roles = Role::MEMBER;

    protected $user;

    protected function seedData()
    {
        parent::seedData();
        $service = $this->app->make(UserServiceContract::class);
        $this->user = $service->create(User::fromFactory()->raw());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetUser()
    {
        $user = $this->getActingUser();
        $http = $this->http('GET', '/v1/users/me');
        $http->assertStatus(200);
        $userTransformer = UserTransformer::resource($user)->serialize();
        $httpData = $this->decodeHttpResponse($http);
        $this->assertEquals($userTransformer, $httpData);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAssignRole()
    {
        $user = $this->getActingUser();

        $this->assertFalse($user->hasRole(Role::ADMIN));

        $http = $this->http('PATCH', '/v1/users/' . $user->id, ['roles' => [Role::ADMIN]]);
        $http->assertStatus(403);

        $this->setUserRoles(Role::ADMIN);
        $this->assertTrue($user->fresh()->hasRole(Role::ADMIN));
        $http = $this->http('PATCH', '/v1/users/' . $user->id, ['roles' => [Role::ADMIN]]);
        $http->assertStatus(200);

        $user = User::find($user->id);
        $this->assertTrue($user->hasRole(Role::ADMIN));
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndexUsers()
    {
        $http = $this->http('GET', '/v1/users');
        $http->assertStatus(403);

        $this->setUserRoles(Role::ADMIN);

        $http = $this->http('GET', '/v1/users');
        $http->assertStatus(200);
    }

}
