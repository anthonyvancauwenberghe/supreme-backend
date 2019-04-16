<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 15.10.18
 * Time: 23:21.
 */

namespace Modules\Authorization\Transformers;

use Foundation\Abstracts\Transformers\Transformer;

class PermissionTransformer extends Transformer
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'  => $this->name,
        ];
    }
}
