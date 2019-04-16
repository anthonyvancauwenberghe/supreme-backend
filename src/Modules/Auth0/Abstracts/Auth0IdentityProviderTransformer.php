<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 13.10.18
 * Time: 19:07.
 */

namespace Modules\Auth0\Abstracts;

abstract class Auth0IdentityProviderTransformer
{
    protected function transformBase($profile)
    {
        return [
            'name'           => $profile->name,
            'avatar'         => $profile->picture ?? null,
            'email'          => $profile->email,
            'email_verified' => $profile->email_verified ?? false,
        ];
    }

    public function transformProfile(\stdClass $profile)
    {
        $base = $this->transformBase($profile);
        $child = $this->transform($profile);

        return array_merge($base, $child);
    }

    abstract protected function transform($profile): array;
}
