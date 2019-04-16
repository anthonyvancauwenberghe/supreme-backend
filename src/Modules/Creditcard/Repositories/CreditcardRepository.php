<?php

namespace Modules\Creditcard\Repositories;

use Foundation\Abstracts\Repositories\Repository;
use Modules\Creditcard\Contracts\CreditcardRepositoryContract;
use Modules\Creditcard\Entities\Creditcard;

class CreditcardRepository extends Repository implements CreditcardRepositoryContract
{
    protected $eloquent = Creditcard::class;
}
