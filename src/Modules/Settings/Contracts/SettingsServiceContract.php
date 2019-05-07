<?php

namespace Modules\Settings\Contracts;

use Modules\Settings\Entities\Settings;
use Modules\Settings\Dtos\CreateSettingsData;
use Modules\Settings\Dtos\UpdateSettingsData;
use Illuminate\Database\Eloquent\Collection;
use Modules\User\Entities\User;

interface SettingsServiceContract
{
    /**
     * @param $id
     * @return Settings
     */
    public function find($id): Settings;

    /**
     * @param $user
     * @return Settings[]
     */
    public function fromUser($user): Collection;

    /**
     * @param $id
     * @param CreateSettingsData $data
     * @return Settings
     */
    public function create(CreateSettingsData $data, User $user): Settings;

    /**
     * @param $id
     * @param UpdateSettingsData $data
     * @return Settings
     */
    public function update($id, UpdateSettingsData $data): Settings;

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool;
}
