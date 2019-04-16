<?php

namespace Modules\Creditcard\Transformers;

use Foundation\Abstracts\Transformers\Transformer;
use Foundation\Exceptions\Exception;
use Modules\Creditcard\Entities\Creditcard;

class CreditcardTransformer extends Transformer
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
    public function transformResource(Creditcard $creditcard)
    {
        return $creditcard->toArray();
    }
}
