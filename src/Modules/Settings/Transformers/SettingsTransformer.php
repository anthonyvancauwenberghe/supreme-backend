<?php

namespace Modules\Settings\Transformers;

use Foundation\Abstracts\Transformers\Transformer;
use Foundation\Exceptions\Exception;
use Modules\Settings\Entities\Settings;

class SettingsTransformer extends Transformer
{

    /**
     * Determines wich relations can be requested with the resource.
     *
     * @var array
     */
    public $available = [];

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
            'created_at' => $settings->created_at,
            'updated_at' => $settings->updated_at,
        ];
    }
}
