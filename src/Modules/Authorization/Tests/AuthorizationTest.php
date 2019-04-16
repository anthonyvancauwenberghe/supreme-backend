<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 22-10-18
 * Time: 17:27.
 */

namespace Modules\Authorization\Tests;

use Foundation\Abstracts\Tests\TestCase;
use Modules\Authorization\Entities\Role;
use Modules\User\Entities\User;

class AuthorizationTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    protected function seedData()
    {
        $this->user = factory(User::class)->create();
    }

    public function testAdminAssignmentRole()
    {
        $this->assertFalse($this->user->hasRole(Role::ADMIN));
        $this->user->assignRole(Role::ADMIN);
        $this->assertTrue($this->user->hasRole(Role::ADMIN));
    }
}
