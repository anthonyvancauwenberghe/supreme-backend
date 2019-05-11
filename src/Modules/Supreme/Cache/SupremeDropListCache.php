<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 11.05.19
 * Time: 13:57
 */

namespace Modules\Supreme\Cache;


use Foundation\Cache\SimpleObjectCache;

class SupremeDropListCache extends SimpleObjectCache
{
    protected static $key = "supreme:droplist";

    protected static $ttl = 3600 * 24 * 1;
}
