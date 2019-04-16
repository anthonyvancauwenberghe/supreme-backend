<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 29.10.18
 * Time: 16:29.
 */

namespace Foundation\Traits;

trait MutatesRequest
{
    public function injectUserId($request): array
    {
        return array_merge($request->toArray(), ['user_id' => get_authenticated_user_id()]);
    }
}
