<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 05.03.19
 * Time: 13:08.
 */

namespace Modules\Authorization\Traits;

use Modules\Authorization\Entities\Role;

trait UserTestRoles
{
    public function setUp(): void
    {
        parent::setUp();

        if (isset($this->roles)) {
            $this->setUserRoles($this->roles);
        } else {
            $this->setUserRoles(Role::GUEST);
        }
    }

    protected function setUserRoles($roles)
    {
        $this->getActingUser()->syncRoles($roles);
    }
}
