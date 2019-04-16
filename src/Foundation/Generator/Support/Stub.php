<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 08.03.19
 * Time: 18:28.
 */

namespace Foundation\Generator\Support;

class Stub extends \Nwidart\Modules\Support\Stub
{
    /**
     * Get stub path.
     *
     * @return string
     */
    public function getPath()
    {
        return get_foundation_path() . '/Generator/Stubs/' . $this->path;
    }

    public function getName()
    {
        return $this->path;
    }

    public function getOptions() :array {
        return $this->getReplaces();
    }
}
