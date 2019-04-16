<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 13.10.18
 * Time: 22:22.
 */

namespace Modules\Auth0\Traits;

trait Auth0Model
{
    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName()
    {
        return 'identity_id';
    }

    public function getIdAttribute($value = null)
    {
        return $this->getKey();
    }

    public function get_idAttribute($value = null)
    {
        return $this->getKey();
    }
}
