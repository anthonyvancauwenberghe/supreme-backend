<?php

namespace Modules\Order\Dtos;

use Foundation\Abstracts\Dtos\Dto;

class CreateOrderData extends Dto
{
    /**
     * @var int $item_id
     */
    public $item_id;

    /**
     * @var int $style_id
     */
    public $style_id;

    /**
     * @var int $size_id
     */
    public $size_id;
}
