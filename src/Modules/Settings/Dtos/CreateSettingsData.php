<?php

namespace Modules\Settings\Dtos;

use Foundation\Abstracts\Dtos\Dto;

class CreateSettingsData extends Dto
{
    /**
     * @var bool
     */
    public $restock_notifications = false;

    /**
     * @var bool
     */
    public $wishlist_notifications = false;

    /**
     * @var bool
     */
    public $drop_notifications = false;

    /**
     * @var bool
     */
    public $mobile_api = true;

    /**
     * @var bool
     */
    public $recaptcha_bypass = false;

    /**
     * @var float
     */
    public $checkout_delay = 3.0;
}
