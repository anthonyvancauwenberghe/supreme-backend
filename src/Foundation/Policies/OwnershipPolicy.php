<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 11.10.18
 * Time: 15:35.
 */

namespace Foundation\Policies;

use Foundation\Abstracts\Policies\Policy;
use Foundation\Contracts\ModelPolicyContract;
use Foundation\Contracts\Ownable;
use Foundation\Exceptions\Exception;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Authenticatable;
use Modules\User\Entities\User;

class OwnershipPolicy extends Policy implements ModelPolicyContract
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can access the model.
     *
     * @param User $owner
     *
     * @throws Exception
     *
     * @return bool
     */
    public function access($owner, $ownable): bool
    {
        return $this->isOwner($owner, $ownable);
    }

    /**
     * @param User $user
     * @param Ownable $model
     *
     * @throws Exception
     *
     * @return bool
     */
    protected function isOwner($owner, $model): bool
    {
        if ($owner instanceof $model) {
            return $owner->getKey() === $model->getKey();
        } elseif (class_implements_interface($model, Ownable::class)) {
            $ownerModel = $model->ownedBy();
            $ownable = $ownerModel::find($model->ownerId());

            if ($ownable === null) {
                throw new Exception("Recursive ownershippolicy lookup failed. Owner model does not exist so couldn't resolve the model owner");
            }
            elseif ($ownable instanceof $owner || class_implements_interface($ownable, Ownable::class)){
                return $this->isOwner($owner, $ownable);
            }
        }

        throw new Exception("Recursive ownershippolicy lookup failed. Not all models implemented the ownable interface so couldn't resolve the model owner");
    }

    /**
     * Determine if the given user can access the model.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the given user can update the model.
     *
     * @param User $user
     *
     * @throws Exception
     *
     * @return bool
     */
    public function update(User $user, $model): bool
    {
        return true;
    }

    /**
     * @param User $user
     * @param $model
     *
     * @return bool
     */
    public function delete(User $user, $model): bool
    {
        return true;
    }

    /**
     * @param User $user
     * @param $ability
     *
     * @return bool|null
     */
    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
