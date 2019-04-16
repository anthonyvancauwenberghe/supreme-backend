<?php

namespace Modules\User\Repositories;

use Foundation\Abstracts\Repositories\Repository;
use Modules\User\Contracts\UserRepositoryContract;
use Modules\User\Entities\User;

class UserRepository extends Repository implements UserRepositoryContract
{
    protected $eloquent = User::class;
}
