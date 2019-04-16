<?php

namespace Modules\Creditcard\Services;

use Modules\Creditcard\Entities\Creditcard;
use Modules\Creditcard\Events\CreditcardWasCreatedEvent;
use Modules\Creditcard\Events\CreditcardWasUpdatedEvent;
use Modules\Creditcard\Events\CreditcardWasDeletedEvent;
use Modules\Creditcard\Contracts\CreditcardServiceContract;
use Modules\Creditcard\Dtos\CreateCreditcardData;
use Modules\Creditcard\Dtos\UpdateCreditcardData;
use Modules\Creditcard\Contracts\CreditcardRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

class CreditcardService implements CreditcardServiceContract
{

    /**
     * @var CreditcardRepositoryContract
     */
    protected $repository;

    /**
     * CreditcardService constructor.
     * @param $repository
     */
    public function __construct(CreditcardRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return Creditcard
     */
    public function find($id): Creditcard
    {
        return $this->repository->findOrResolve($id);
    }

    /**
     * @param $id
     * @return Creditcard[]
     */
    public function getByUserId($id): Collection
    {
        return $this->repository->findByField('user_id', $id)->get();
    }

    /**
     * @param $id
     * @param UpdateCreditcardData $data
     * @return Creditcard
     */
    public function update($id, UpdateCreditcardData $data): Creditcard
    {
        $creditcard = $this->repository->update($id, $data->toArray());
        event(new CreditcardWasUpdatedEvent($creditcard));
        return $creditcard;
    }

    /**
     * @param CreateCreditcardData $data
     * @return Creditcard
     */
    public function create(CreateCreditcardData $data): Creditcard
    {
        $creditcard = $this->repository->create($data->toArray());
        event(new CreditcardWasCreatedEvent($creditcard));
        return $creditcard;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $creditcard = $this->repository->findOrResolve($id);
        $deleted = $this->repository->delete($creditcard);
        if($deleted)
            event(new CreditcardWasDeletedEvent($creditcard));
        return $deleted;
    }
}