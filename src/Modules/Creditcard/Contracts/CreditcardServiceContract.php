<?php

namespace Modules\Creditcard\Contracts;

use Modules\Creditcard\Entities\Creditcard;
use Modules\Creditcard\Dtos\CreateCreditcardData;
use Modules\Creditcard\Dtos\UpdateCreditcardData;
use Illuminate\Database\Eloquent\Collection;
use Modules\User\Entities\User;

interface CreditcardServiceContract
{
    /**
     * @param $id
     * @return Creditcard
     */
    public function find($id): Creditcard;

    /**
     * @param $userId
     * @return Creditcard[]
     */
    public function fromUser($userId): Collection;

    /**
     * @param $id
     * @param CreateCreditcardData $data
     * @return Creditcard
     */
    public function create(CreateCreditcardData $data, User $user): Creditcard;

    /**
     * @param $id
     * @param UpdateCreditcardData $data
     * @return Creditcard
     */
    public function update($id, UpdateCreditcardData $data): Creditcard;

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool;
}
