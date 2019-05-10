<?php

namespace Modules\Settings\Transformers;

use Foundation\Abstracts\Transformers\Transformer;
use Foundation\Exceptions\Exception;
use Modules\Settings\Entities\Settings;
use Modules\Settings\Permissions\SettingsPermission;
use Modules\Supreme\Permissions\SupremePermission;

class SettingsTransformer extends Transformer
{
    /**
     * Transform the resource into an array.
     *
     * @throws Exception
     *
     * @return array
     */
    public function transformResource(Settings $settings)
    {
        return [
            'id' => $settings->id,
            'restock_notifications' => $settings->restock_notifications,
            'wishlist_notifications' => $settings->wishlist_notifications,
            'drop_notifications' => $settings->drop_notifications,
            'mobile_api' => $settings->mobile_api,
            'recaptcha_bypass' => $settings->recaptcha_bypass,
            'checkout_delay' => $settings->user->hasPermissionTo(SettingsPermission::EDIT_CHECKOUT_DELAY)
                ? $settings->checkout_delay : config('settings.slow_checkout_delay'),
            'created_at' => $settings->created_at,
            'updated_at' => $settings->updated_at,
        ];
    }
}
