<?php

namespace Modules\Shipping\Dtos;

use Foundation\Abstracts\Dtos\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class CreateShippingData extends Dto
{
    /**
     * @var string $first_name
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=50)
     */
    public $first_name;

    /**
     * @var string $last_name
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=50)
     */
    public $last_name;

    /**
     * @var string $email
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    public $email;

    /**
     * @var string $telephone
     * @Assert\Length(min=5, max=25)
     * @Assert\NotBlank()
     */
    public $telephone;

    /**
     * @var string $address
     * @Assert\Length(min=3, max=100)
     * @Assert\NotBlank()
     */
    public $address;

    /**
     * @var string $address_2
     * @Assert\Length(min=3, max=100)
     */
    public $address_2="";

    /**
     * @var string $address_3
     * @Assert\Length(min=3, max=100)
     */
    public $address_3="";

    /**
     * @var string $city
     * @Assert\Length(min=3, max=50)
     * @Assert\NotBlank()
     */
    public $city;

    /**
     * @var string $postal_code
     * @Assert\Length(min=3, max=50)
     * @Assert\NotBlank()
     */
    public $postal_code;

    /**
     * @var string $country
     * @Assert\Length(min=3, max=50)
     * @Assert\NotBlank()
     */
    public $country;

    /**
     * @var bool $primary
     */
    public $primary = false;
}
