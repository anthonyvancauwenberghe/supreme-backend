<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 11.10.18
 * Time: 13:51.
 */

namespace Foundation\Contracts;

use Modules\User\Entities\User;

interface ModelPolicyContract
{
    public function create(User $user): bool;

    public function update(User $user, $model): bool;

    public function delete(User $user, $model): bool;
}
