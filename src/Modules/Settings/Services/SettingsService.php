<?php

namespace Modules\Settings\Services;

use Modules\Settings\Entities\Settings;
use Modules\Settings\Events\SettingsWasCreatedEvent;
use Modules\Settings\Events\SettingsWasUpdatedEvent;
use Modules\Settings\Contracts\SettingsServiceContract;
use Modules\Settings\Dtos\CreateSettingsData;
use Modules\Settings\Dtos\UpdateSettingsData;
use Modules\Settings\Contracts\SettingsRepositoryContract;
use Modules\Settings\Permissions\SettingsPermission;
use Modules\User\Entities\User;

class SettingsService implements SettingsServiceContract
{

    /**
     * @var SettingsRepositoryContract
     */
    protected $repository;

    /**
     * SettingsService constructor.
     * @param $repository
     */
    public function __construct(SettingsRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $user
     * @return Settings
     */
    public function fromUser($user): Settings
    {
        if ($user instanceof User)
            $user = $user->id;
        return $this->repository->findByField('user_id', $user)->first();
    }

    /**
     * @param UpdateSettingsData $data
     * @param User $user
     * @return Settings
     */
    public function update(UpdateSettingsData $data, User $user): Settings
    {
        $settings = $this->fromUser($user);

        if(!$user->hasPermissionTo(SettingsPermission::EDIT_CHECKOUT_DELAY))
            $data->except('checkout_delay');

        $settings->update($data->toArray());
        event(new SettingsWasUpdatedEvent($settings));
        return $settings;
    }

    /**
     * @param CreateSettingsData $data
     * @return Settings
     */
    public function create(CreateSettingsData $data, User $user): Settings
    {
        $data->with('user_id', $user->id);
        $settings = $this->repository->create($data->toArray());
        event(new SettingsWasCreatedEvent($settings));
        return $settings;
    }
}