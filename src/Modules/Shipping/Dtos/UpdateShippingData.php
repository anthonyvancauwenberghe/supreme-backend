<?php

namespace Modules\Shipping\Dtos;

use Foundation\Abstracts\Dtos\Dto;

class UpdateShippingData extends Dto
{
    /**
     * @var string|optional $fullName
     */
    public $full_name;
    /**
     * @var string|optional $email
     */
    public $email;
    /**
     * @var string|optional $telephone
     */
    public $telephone;
    /**
     * @var string|optional $address
     */
    public $address;
    /**
     * @var string|optional $address_2
     */
    public $address_2;
    /**
     * @var string|optional $address_3
     */
    public $address_3;
    /**
     * @var string|optional $city
     */
    public $city;
    /**
     * @var string|optional $postal_code
     */
    public $postal_code;
    /**
     * @var string|optional $country
     */
    public $country;
}
