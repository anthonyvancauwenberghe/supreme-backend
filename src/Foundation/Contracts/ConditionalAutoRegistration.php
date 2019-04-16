<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 30.10.18
 * Time: 14:11.
 */

namespace Foundation\Contracts;

interface ConditionalAutoRegistration
{
    public function registrationCondition(): bool;
}
