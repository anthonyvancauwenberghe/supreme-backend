<?php

namespace Modules\Creditcard\Repositories;

use Foundation\Abstracts\Repositories\Repository;
use Modules\Creditcard\Contracts\CreditcardRepositoryContract;
use Modules\Creditcard\Entities\Creditcard;
use Modules\Creditcard\Events\CreditcardWasUpdatedEvent;

class CreditcardRepository extends Repository implements CreditcardRepositoryContract
{
    protected $eloquent = Creditcard::class;

    public function setPrimary($card): Creditcard
    {
        $creditcard = $this->findOrResolve($card);

        $this->updateWhere(['user_id' => $creditcard->user_id], ["primary" => false]);

        return $this->update($creditcard, ["primary" => true]);
    }


}
