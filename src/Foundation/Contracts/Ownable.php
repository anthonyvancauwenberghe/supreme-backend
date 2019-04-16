<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 11.10.18
 * Time: 13:51.
 */

namespace Foundation\Contracts;

interface Ownable
{
    public function ownerId();

    public function ownedBy();

    public function ownerKey();
}
