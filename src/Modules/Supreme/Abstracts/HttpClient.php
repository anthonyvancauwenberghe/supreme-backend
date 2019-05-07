<?php


namespace Modules\Supreme\Abstracts;


use Campo\UserAgent;
use GuzzleHttp\Client;

abstract class HttpClient
{
    protected $http;

    public function __construct(string $baseUrl, ?string $proxy = null)
    {
        $data = $this->buildHttpClientData($baseUrl, $proxy);
        $this->http = new Client($data);
    }

    protected function buildHttpClientData($baseUrl, $proxy)
    {
        $data = [
            'base_uri' => $baseUrl,
            'User-Agent' => UserAgent::random([
                'os_type' => ['Android', 'iOS'],
                'device_type' => ['Mobile', 'Tablet']
            ]),
            "headers" => [
                'Cache-Control' => 'no-cache',
                "Accept" => "application/json",
                "Content-type" => "application/json"
            ]];
        if ($proxy !== null)
            $data['proxy'] = $proxy;

        return $data;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function decodeResponse($response)
    {
        return json_decode($response->getBody()->getContents(),true);
    }

    public function request($route){
        return $this->decodeResponse($this->http->get($route));
    }

    public function getClient() :Client{
        return $this->http;
    }
}