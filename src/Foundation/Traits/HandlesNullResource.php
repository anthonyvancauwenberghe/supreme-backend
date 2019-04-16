<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 15.11.18
 * Time: 19:49.
 */

namespace Foundation\Traits;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait HandlesNullResource
{
    public function exists($model)
    {
        if ($model === null) {
            throw new NotFoundHttpException('Could not found resource.');
        }
    }
}
