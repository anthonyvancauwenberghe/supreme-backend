<?php

namespace Modules\License\Policies;

use Foundation\Exceptions\Exception;
use Foundation\Policies\OwnershipPolicy;
use Modules\License\Contracts\LicenseServiceContract;
use Modules\User\Entities\User;

class LicensePolicy extends OwnershipPolicy
{
    /**
     * @var LicenseServiceContract $service
     */
    protected $service;

    /**
     * LicensePolicy constructor.
     *
     * @param LicenseServiceContract $service
     */
    public function __construct(LicenseServiceContract $service)
    {
        $this->service = $service;
    }

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
        return parent::access($user, $model);
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
        return parent::create($user);
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
        return parent::update($user, $model);
    }

    /**
     * @param User $user
     * @param $model
     *
     * @return bool
     */
    public function delete(User $user, $model): bool
    {
        return parent::delete($user, $model);
    }

    /**
     * @param User $user
     * @param $ability
     * @return bool|null
     */
    public function before($user, $ability)
    {
        return parent::before($user, $ability);
    }
}
