<?php

namespace Modules\License\Services;

use Modules\License\Entities\License;
use Modules\License\Events\LicenseWasCreatedEvent;
use Modules\License\Events\LicenseWasTransferredEvent;
use Modules\License\Events\LicenseWasUpdatedEvent;
use Modules\License\Events\LicenseWasDeletedEvent;
use Modules\License\Contracts\LicenseServiceContract;
use Modules\License\Dtos\CreateLicenseData;
use Modules\License\Dtos\UpdateLicenseData;
use Modules\License\Contracts\LicenseRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Modules\User\Entities\User;

class LicenseService implements LicenseServiceContract
{

    /**
     * @var LicenseRepositoryContract
     */
    protected $repository;

    /**
     * LicenseService constructor.
     * @param $repository
     */
    public function __construct(LicenseRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return License
     */
    public function find($id): License
    {
        return $this->repository->findOrResolve($id);
    }

    /**
     * @param $user
     * @return License[]
     */
    public function fromUser($user): Collection
    {
        if ($user instanceof User)
            $user = $user->id;
        return $this->repository->findByField('user_id', $user);
    }

    /**
     * @param $id
     * @param UpdateLicenseData $data
     * @return License
     */
    public function update($id, UpdateLicenseData $data): License
    {
        $license = $this->repository->update($id, $data->toArray());
        event(new LicenseWasUpdatedEvent($license));
        return $license;
    }

    public function transfer($id, User $user) : License
    {
        return tap($this->update($id, new UpdateLicenseData(['user_id' => $user->id])), function ($license) {
            new LicenseWasTransferredEvent($license);
        });
    }

    /**
     * @param CreateLicenseData $data
     * @return License
     */
    public function create(CreateLicenseData $data, User $user): License
    {
        $data->with('user_id', $user->id);
        $license = $this->repository->create($data->toArray());
        event(new LicenseWasCreatedEvent($license));
        return $license;
    }


    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $license = $this->repository->findOrResolve($id);
        $deleted = $this->repository->delete($license);
        if ($deleted)
            event(new LicenseWasDeletedEvent($license));
        return $deleted;
    }
}
