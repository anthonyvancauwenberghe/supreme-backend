<?php

namespace Modules\License\Dtos;

use Foundation\Abstracts\Dtos\Dto;

class CreateLicenseData extends Dto
{
    /**
     * @var string $type
     */
    public $type;

    /**
     * @var string $expires_at
     */
    public $expires_at;
}
