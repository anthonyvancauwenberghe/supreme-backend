<?php

namespace Modules\Shipping\Dtos;

use Larapie\DataTransferObject\Annotations\Inherit;
use Larapie\DataTransferObject\Annotations\Optional;

class UpdateShippingData extends CreateShippingData
{
    /**
     * @Optional
     * @Inherit
     */
    public $first_name;

    /**
     * @Optional
     * @Inherit
     */
    public $last_name;

    /**
     * @Optional
     * @Inherit
     */
    public $email;

    /**
     * @Optional
     * @Inherit
     */
    public $telephone;

    /**
     * @Optional
     * @Inherit
     */
    public $address;

    /**
     * @Optional
     * @Inherit
     */
    public $address_2;

    /**
     * @Optional
     * @Inherit
     */
    public $address_3;

    /**
     * @Optional
     * @Inherit
     */
    public $city;

    /**
     * @Optional
     * @Inherit
     */
    public $postal_code;

    /**
     * @Optional
     * @Inherit
     */
    public $country;

    /**
     * @Optional
     * @Inherit
     */
    public $primary;
}
