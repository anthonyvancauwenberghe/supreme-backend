<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 22-10-18
 * Time: 20:02.
 */

namespace Modules\Authorization\Attributes;

interface Roles
{
    const ADMIN = 'admin';
    const MEMBER = 'member';
    const GUEST = 'guest';
    const SCRIPTER = 'scripter';
    const TRUSTED_SCRIPTER = 'scripter.trusted';
}
