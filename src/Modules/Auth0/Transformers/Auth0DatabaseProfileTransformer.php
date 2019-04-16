<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 13.10.18
 * Time: 19:06.
 */

namespace Modules\Auth0\Transformers;

use Modules\Auth0\Abstracts\Auth0IdentityProviderTransformer;

class Auth0DatabaseProfileTransformer extends Auth0IdentityProviderTransformer
{
    protected function transform($profile): array
    {
        return [
            'gender'   => $profile->gender ?? 'unknown',
            'username' => $profile->nickname ?? 'stranger',
        ];
    }
}
