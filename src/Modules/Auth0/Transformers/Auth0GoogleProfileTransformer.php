<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 13.10.18
 * Time: 19:06.
 */

namespace Modules\Auth0\Transformers;

use Modules\Auth0\Abstracts\Auth0IdentityProviderTransformer;

class Auth0GoogleProfileTransformer extends Auth0IdentityProviderTransformer
{
    public function transform($profile): array
    {
        return [
            'email'          => $profile->email,
            'name'           => $profile->name,
            'gender'         => $profile->gender ?? 'unknown',
            'username'       => $profile->nickname ?? 'stranger',
            'avatar'         => $profile->picture,
            'email_verified' => $profile->email_verified,
        ];
    }
}
