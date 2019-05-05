<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 11.10.18
 * Time: 23:33.
 */

namespace Foundation\Traits;

trait HasOwner
{
    public function ownerId()
    {
        return $this->{$this->ownerKey()};
    }

    public function ownerKey()
    {
        return strtolower(get_short_class_name($this->ownedBy())) . '_id';
    }

    public function owner()
    {
        return $this->belongsTo($this->ownedBy(), $this->ownerKey());
    }
}
