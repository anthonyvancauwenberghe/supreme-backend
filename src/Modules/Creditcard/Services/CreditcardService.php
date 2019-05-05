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
use Modules\User\Entities\User;

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
     * @param User|string|int $id
     * @return Creditcard[]
     */
    public function fromUser($user): Collection
    {
        if ($user instanceof User)
            $user = $user->id;
        return $this->repository->findByField('user_id', $user);
    }

    /**
     * @param $id
     * @param UpdateCreditcardData $data
     * @return Creditcard
     */
    public function update($id, UpdateCreditcardData $data): Creditcard
    {
        $creditcard = $this->repository->findOrResolve($id);

        $data->except('primary');

        if ($data->exists('number'))
            $data->override('number', encrypt($data->number));

        if ($updated = !empty($input = $data->toArray()))
            $creditcard = $this->repository->update($id, $input);

        if ($data->exists('primary')) {
            if ($data->primary)
                $creditcard = $this->repository->setPrimary($creditcard);
            else
                $creditcard = $this->repository->setPrimary($this->fromUser($creditcard->user_id)->first());
            $updated = true;
        }

        if ($updated)
            event(new CreditcardWasUpdatedEvent($creditcard));

        return $creditcard;
    }

    /**
     * @param CreateCreditcardData $data
     * @return Creditcard
     */
    public function create(CreateCreditcardData $data, User $user): Creditcard
    {
        $primary = $data->primary ?? false;

        $data
            ->with('user_id', $user->id)
            ->override('number', encrypt($data->number))
            ->override('primary', false);

        $count = $this->fromUser($user)->count();

        $creditcard = $this->repository->create($data->toArray());

        if ($count === 0 || $primary)
            $creditcard = $this->setPrimary($creditcard);

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
        if ($deleted) {
            event(new CreditcardWasDeletedEvent($creditcard));
            if ($creditcard->primary) {
                $creditcard = $this->fromUser($creditcard->user_id)->first();
                if ($creditcard !== null) {
                    $this->setPrimary($creditcard);
                }
            }
        }
        return $deleted;
    }

    protected function setPrimary($creditCard)
    {
        return $this->update($creditCard, UpdateCreditcardData::make(["primary" => true]));
    }

}