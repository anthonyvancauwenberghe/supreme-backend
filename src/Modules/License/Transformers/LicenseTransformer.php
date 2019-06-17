<?php

namespace Modules\License\Transformers;

use Carbon\Carbon;
use Foundation\Abstracts\Transformers\Transformer;
use Foundation\Exceptions\Exception;
use Modules\License\Entities\License;

class LicenseTransformer extends Transformer
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
    public function transformResource(License $license)
    {
        return [
            'id' => $license->id,
            'type' => $license->type,
            "expires_at" => $license->expires_at,
            "is_expired" => Carbon::now()->greaterThan($license->expires_at),
            'created_at' => $license->created_at
        ];
    }
}
