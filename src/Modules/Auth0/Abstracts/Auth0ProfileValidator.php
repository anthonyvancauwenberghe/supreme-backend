<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 13.10.18
 * Time: 20:31.
 */

namespace Modules\Auth0\Abstracts;

abstract class Auth0ProfileValidator
{
    protected $requiredAttributes = [
        'email',
        'name',
        'picture',
    ];

    public function validate(\stdClass $profile)
    {
        return $this->validateRequiredAttributes($profile);
    }

    private function validateRequiredAttributes(\stdClass $profile)
    {
        return array_keys_exists($this->requiredAttributes, (array) $profile);
    }
}
