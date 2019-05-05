<?php

namespace Modules\Creditcard\Transformers;

use Foundation\Abstracts\Transformers\Transformer;
use Foundation\Exceptions\Exception;
use Modules\Creditcard\Entities\Creditcard;

class HiddenCreditcardTransformer extends Transformer
{

    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function transformResource(Creditcard $creditcard)
    {
        return [
            "id" => $creditcard->id,
            "type" => $creditcard->type,
            "number" => str_repeat('*', strlen($creditcard->number) - 4) . substr($creditcard->number, -4),
            "cvv" => str_repeat("*", strlen($creditcard->cvv)),
            "primary" => $creditcard->primary
        ];
    }
}
