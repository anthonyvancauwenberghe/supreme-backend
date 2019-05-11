<?php

namespace Modules\Device\Dtos;

use Foundation\Abstracts\Dtos\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class CreateDeviceData extends Dto
{
    /**
     * @var string
     */
    public $device_id;

    /**
     * @var string
     * @Assert\Choice({"IOS","ANDROID", "DESKTOP"})
     */
    public $device_type;

    /**
     * @var bool
     */
    public $notify_restock = false;

    /**
     * @var bool
     */
    public $notify_wishlist = false;

    /**
     * @var bool
     */
    public $notify_drop = false;
}
