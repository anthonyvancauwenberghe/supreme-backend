<?php

namespace Modules\Device\Dtos;

use Foundation\Abstracts\Dtos\Dto;
use Larapie\DataTransferObject\Annotations\Optional;

class UpdateDeviceData extends Dto
{
    /**
     * @var bool
     * @Optional
     */
    public $notify_restock;

    /**
     * @var bool
     * @Optional
     */
    public $notify_wishlist;

    /**
     * @var bool
     * @Optional
     */
    public $notify_drop;

    /**
     * @var bool
     * @Optional
     */
    public $mobile_api;

    /**
     * @var bool
     * @Optional
     */
    public $recaptcha_bypass;

    /**
     * @var float
     * @Optional
     */
    public $checkout_delay;
}
