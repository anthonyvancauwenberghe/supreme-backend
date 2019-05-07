<?php


namespace Modules\Supreme\Abstracts;

class SupremeHttpClient extends HttpClient
{
    public $baseUrl= "https://supremenewyork.com";

    protected $region;

    /**
     * SupremeParser constructor.
     * @param string $region
     */
    public function __construct(string $region)
    {
        parent::__construct($this->baseUrl, $this->getProxy($region));
    }

    protected function getProxy($region){
        return null; //TODO RANDOM PICK PROXY BY REGION
    }

    public function request($route){
        return $this->decodeResponse($this->http->get($route));
    }

    public function requestAsync($route, $callback){
        return $this->http->getAsync($route)->then($callback);
    }
}