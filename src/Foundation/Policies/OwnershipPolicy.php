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
     * @param User $user
     *
     * @throws Exception
     *
     * @return bool
     */
    public function access($user, $model): bool
    {
        return $this->userIsModelOwner($user, $model);
    }

    /**
     * @param User    $user
     * @param Ownable $model
     *
     * @throws Exception
     *
     * @return bool
     */
    protected function userIsModelOwner(User $user, Ownable $model): bool
    {
        if (class_implements_interface($model->ownedBy(), Authenticatable::class)) {
            return $user->id === $model->ownerId();
        }

        $ownerModel = $model->ownedBy();
        $owner = $ownerModel::find($model->ownerId());

        if (class_implements_interface($owner, Ownable::class)) {
            return $this->userIsModelOwner($user, $owner);
        }

        throw new Exception("recursive ownershippolicy lookup failed. Not all models implemented ownable so couldn't identify if user owned model");
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
