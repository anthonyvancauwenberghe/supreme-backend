<?php

namespace Foundation\Tests;

use Foundation\Abstracts\Tests\TestCase;
use Modules\User\Entities\User;

class OwnershipPolicyTest extends TestCase
{
    public function testAccessPolicy()
    {
        $user = $this->actAsRandomUser();
        $user2 = User::fromFactory()->create();
        $this->assertTrue($user->can('access', $user));
        $this->assertFalse($user2->can('access', $user));
    }
}
