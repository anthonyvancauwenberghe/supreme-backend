<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 05.03.19
 * Time: 11:54.
 */

namespace Modules\Auth0\Abstracts;

use Foundation\Abstracts\Tests\HttpTest;
use Foundation\Abstracts\Tests\TestResponse;
use Modules\Auth0\Traits\Auth0TestUser;
use Modules\Authorization\Traits\UserTestRoles;
use Modules\User\Entities\User;

abstract class AuthorizedHttpTest extends HttpTest
{
    use Auth0TestUser, UserTestRoles;

    protected function http(string $method, string $route, array $payload = [], array $headers = []): TestResponse
    {
        $headers['Authorization'] = 'Bearer '.$this->getUserAuth0Token()->id_token;

        return parent::http($method, $route, $payload, $headers);
    }

    protected function httpNoAuth(string $method, string $route, array $payload = [], array $headers = []): TestResponse
    {
        return parent::http($method, $route, $payload, $headers);
    }

    protected function actingUser()
    {
        return $this->getTestUser();
    }

    public function actingAs($user, $driver = null)
    {
        if (! $user->is($this->getTestUser())) {
            throw new \Foundation\Exceptions\Exception('cannot set another user for authorized http tests. Sync other roles/permissions instead.');
        }
        parent::actingAs($user, $driver);
    }
}
