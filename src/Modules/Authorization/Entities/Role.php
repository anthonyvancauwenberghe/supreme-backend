<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 22-10-18
 * Time: 14:13.
 */

namespace Modules\Authorization\Entities;

use Modules\Authorization\Attributes\Roles;

class Role extends \Spatie\Permission\Models\Role implements Roles
{
}
