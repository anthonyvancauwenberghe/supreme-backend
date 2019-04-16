<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 04.10.18
 * Time: 16:15.
 */

namespace Modules\User\Contracts;

use Modules\User\Entities\User;

interface UserServiceContract
{
    public function all();

    public function find($id): ?User;

    public function findByIdentityId($id): ?User;

    public function update($id, $data): ?User;

    public function create($data): User;

    public function delete($id): bool;

    public function newUser($data): User;

    public function setRoles($id, array $roles): void;
}
