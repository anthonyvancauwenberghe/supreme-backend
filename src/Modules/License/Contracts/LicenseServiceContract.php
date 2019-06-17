<?php

namespace Modules\License\Contracts;

use Modules\License\Entities\License;
use Modules\License\Dtos\CreateLicenseData;
use Modules\License\Dtos\UpdateLicenseData;
use Illuminate\Database\Eloquent\Collection;
use Modules\User\Entities\User;

interface LicenseServiceContract
{
    /**
     * @param $id
     * @return License
     */
    public function find($id): License;

    /**
     * @param $user
     * @return License[]
     */
    public function fromUser($user): Collection;

    public function transfer($id,User $user) : License;

    /**
     * @param $id
     * @param CreateLicenseData $data
     * @return License
     */
    public function create(CreateLicenseData $data, User $user): License;

    /**
     * @param $id
     * @param UpdateLicenseData $data
     * @return License
     */
    public function update($id, UpdateLicenseData $data): License;

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool;
}
