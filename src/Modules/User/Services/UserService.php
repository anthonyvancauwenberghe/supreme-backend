<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 04.10.18
 * Time: 16:17.
 */

namespace Modules\User\Services;

use Modules\Authorization\Entities\Role;
use Modules\User\Contracts\UserRepositoryContract;
use Modules\User\Contracts\UserServiceContract;
use Modules\User\Entities\User;
use Modules\User\Events\UserRegisteredEvent;
use Modules\User\Repositories\UserRepository;

class UserService implements UserServiceContract
{

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * UserService constructor.
     * @param $repository
     */
    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function find($id): ?User
    {
        return $this->repository->findOrResolve($id);
    }

    public function findByIdentityId($id): ?User
    {
        return User::cache()->findBy('identity_id', $id);
    }

    public function update($id, $data): ?User
    {
        $user = $this->repository->update($id, $data);
        return $user;
    }

    public function create($data): User
    {
        $user = $this->repository->create($data);
        $user->assignRole(Role::MEMBER);
        event(new UserRegisteredEvent($user));
        return $user;
    }

    public function delete($id): bool
    {
        return $this->repository->delete($id);
    }

    public function newUser($data): User
    {
        $user = new User($data);
        $user->assignRole(Role::MEMBER);
        return $user;
    }

    public function setRoles($id, array $roles): void
    {
        if (!in_array(Role::MEMBER, $roles)) {
            $roles[] = Role::MEMBER;
        }
        $this->find($id)->syncRoles($roles);
    }
}
