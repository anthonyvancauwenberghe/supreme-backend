<?php

namespace Modules\Wishlist\Transformers;

use Foundation\Abstracts\Transformers\Transformer;
use Foundation\Exceptions\Exception;
use Modules\Wishlist\Entities\Wishlist;

class WishlistTransformer extends Transformer
{

    /**
     * Transform the resource into an array.
     *
     * @throws Exception
     *
     * @return array
     */
    public function transformResource(Wishlist $wishlist)
    {
        return [
            'id' => $wishlist->id,
            'item_id' => $wishlist->item_id,
            'style_id' => $wishlist->style_id,
            'size_id'   => $wishlist->size_id,
            'notify'    => $wishlist->notify,
            'created_at' => $wishlist->created_at,
            'updated_at' => $wishlist->updated_at,
        ];
    }
}
