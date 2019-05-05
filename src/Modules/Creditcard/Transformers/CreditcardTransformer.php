<?php

namespace Modules\Creditcard\Transformers;

use Foundation\Abstracts\Transformers\Transformer;
use Foundation\Exceptions\Exception;
use Modules\Creditcard\Entities\Creditcard;

class CreditcardTransformer extends Transformer
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
            "number" => $creditcard->number,
            "expiry_month" => $creditcard->expiry_month,
            "expiry_year" => $creditcard->expiry_year,
            "cvv" => $creditcard->cvv,
            "primary" => $creditcard->primary
        ];
    }
}