<?php

namespace Modules\Creditcard\Contracts;

use Larapie\Repository\Contracts\RepositoryInterface;
use Modules\Creditcard\Entities\Creditcard;

interface CreditcardRepositoryContract extends RepositoryInterface
{
    public function setPrimary($card) :Creditcard;
}
