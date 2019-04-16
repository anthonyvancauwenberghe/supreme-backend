<?php

namespace Modules\Shipping\Dtos;

use Foundation\Abstracts\Dtos\Dto;

class CreateShippingData extends Dto
{
    /**
     * @var string $fullName
     */
    public $full_name;
    /**
     * @var string $email
     */
    public $email;
    /**
     * @var string $telephone
     */
    public $telephone;
    /**
     * @var string $address
     */
    public $address;
    /**
     * @var string|optional $address_2
     */
    public $address_2 = "";
    /**
     * @var string|optional $address_3
     */
    public $address_3 = "";
    /**
     * @var string $city
     */
    public $city;
    /**
     * @var string $postal_code
     */
    public $postal_code;
    /**
     * @var string $country
     */
    public $country;
}
