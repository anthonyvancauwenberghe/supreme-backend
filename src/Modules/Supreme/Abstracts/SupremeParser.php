<?php


namespace Modules\Supreme\Abstracts;


abstract class SupremeParser
{
    protected $region;

    /**
     * SupremeParser constructor.
     * @param string $region
     */
    public function __construct(string $region)
    {
        $this->region = $region;
    }

    protected function http()
    {
        return new SupremeHttpClient($this->region);
    }

    protected function request(string $route)
    {
        return $this->http()->request($route);
    }

    protected function requestAsync($route, $callable)
    {
        return $this->http()->requestAsync($route, $callable);
    }

}