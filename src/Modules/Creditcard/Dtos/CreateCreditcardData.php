<?php

namespace Modules\Creditcard\Dtos;

use Foundation\Abstracts\Dtos\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCreditcardData extends Dto
{
    /**
     * @var string $type
     * @Assert\NotBlank()
     * @Assert\Choice({"american_express", "visa", "master"})
     */
    public $type;

    /**
     * @var string $number
     * @Assert\NotBlank()
     * @Assert\Length(min=10, max=20)
     */
    public $number;

    /**
     * @var int $expiry_month
     * @Assert\NotBlank()
     * @Assert\Range(min = 1, max = 12)
     */
    public $expiry_month;

    /**
     * @var int $expiry_year
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 2019,
     *      max = 2050,
     *      minMessage = "Your credit cannot be expired"
     * )
     */
    public $expiry_year;

    /**
     * @var string $cvv
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=4)
     */
    public $cvv;

    /**
     * @var bool $primary
     */
    public $primary = false;

}
