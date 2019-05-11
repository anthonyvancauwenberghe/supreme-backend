<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 29.10.18
 * Time: 12:06.
 */

namespace Modules\User\Transformers;

use Foundation\Abstracts\Transformers\Transformer;
use Modules\Account\Transformers\AccountTransformer;
use Modules\Authorization\Transformers\RoleTransformer;
use Modules\Settings\Transformers\SettingsTransformer;
use Modules\User\Entities\User;

class UserTransformer extends Transformer
{
    public $include = [
        'roles' => RoleTransformer::class
    ];

    public $available = [];

    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function transformResource(User $user)
    {
        return [
            'id'             => $user->id,
            'name'           => $user->name,
            'email'          => $user->name,
            'email_verified' => $user->email_verified,
            'gender'         => $user->gender,
            'provider'       => $user->provider,
            'created_at'     => $user->created_at,
            'updated_at'     => $user->updated_at,
        ];
    }

    public function transformRoles($roles)
    {
        return collect(RoleTransformer::collection($roles)->serialize())->flatten();
    }
}
