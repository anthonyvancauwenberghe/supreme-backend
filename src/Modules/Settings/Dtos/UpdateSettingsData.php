<?php

namespace Modules\Settings\Dtos;

use Larapie\DataTransferObject\Annotations\Optional;

class UpdateSettingsData extends CreateSettingsData
{
    /**
     * @Optional
     */
    public $restock_notifications;

    /**
     * @Optional
     */
    public $wishlist_notifications;

    /**
     * @Optional
     */
    public $drop_notifications;

    /**
     * @Optional
     */
    public $mobile_api;

    /**
     * @Optional
     */
    public $recaptcha_bypass;

    /**
     * @Optional
     */
    public $checkout_delay;
}
