<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 15.10.18
 * Time: 00:02.
 */

namespace Modules\Auth0\Tests;

use Modules\Auth0\Abstracts\AuthorizedHttpTest;
use Modules\User\Entities\User;

final class AuthorizedTest extends AuthorizedHttpTest
{
    public function testUserIdEqualsIdentityId()
    {
        $user = $this->getActingUser();
        $this->assertEquals($user->identity_id, User::find($user->id)->identity_id);
    }

    public function testAuthorized()
    {
        $user = $this->getActingUser();
        $userId = $user->getKey();
        $http = $this->http('GET', '/authorized');
        $http->assertStatus(200);

        $user->update(['email' => 'blablabla@mail.com']);
        $this->assertEquals(User::find($userId)->email, 'blablabla@mail.com');
        $http = $this->http('GET', '/authorized');
        $http->assertStatus(200);

        $this->assertNotEquals(User::find($user->getKey())->email, 'blablabla@mail.com');
    }

    public function testUnauthorized()
    {
        $http = $this->httpNoAuth('GET', '/authorized');
        $http->assertStatus(401);
    }

    public function testUserPrimaryKey()
    {
        $this->assertEquals(factory(User::class)->create()->getKeyName(), 'id');
    }
}
