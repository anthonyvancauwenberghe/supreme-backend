<?php

namespace Modules\Creditcard\Dtos;

use Larapie\DataTransferObject\Annotations\Inherit;
use Larapie\DataTransferObject\Annotations\Optional;

class UpdateCreditcardData extends CreateCreditcardData
{
    /**
     * @Optional
     * @Inherit
     */
    public $type;

    /**
     * @Optional
     * @Inherit
     */
    public $number;

    /**
     * @Optional
     * @Inherit
     */
    public $expiry_month;

    /**
     * @Optional
     * @Inherit
     */
    public $expiry_year;

    /**
     * @Optional
     * @Inherit
     */
    public $cvv;

    /**
     * @Optional
     * @Inherit
     */
    public $primary;
}
