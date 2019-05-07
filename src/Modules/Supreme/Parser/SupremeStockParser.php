<?php

namespace Modules\Supreme\Parser;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Modules\Supreme\Abstracts\SupremeParser;
use Modules\Supreme\Factory\SupremeItemsFactory;

class SupremeStockParser extends SupremeParser
{
    protected $mainItems = [];

    protected $releaseWeek;

    public function __construct(string $region)
    {
        parent::__construct($region);
        $this->boot();
    }

    protected function getMobileStock(){
        $parser = new SupremeMobileStockParser($this->region);
        return $parser->parse();
    }

    protected function boot()
    {
        $items = $this->getMobileStock();
        $this->releaseWeek = $items['release_week'];
        foreach ($items["products_and_categories"] as $category => $mainItems) {
            foreach($mainItems as $mainItem){
                $this->mainItems[$mainItem['id']] = $mainItem;
            }
        }
    }

    public function parse()
    {
        $this->execute();
    }

    protected function execute()
    {
        $pool = new Pool($this->http()->getClient(), $this->buildRequests($this->mainItems), [
            'concurrency' => 10,
            'fulfilled' => function (Response $response, $index) {
                $factory = new SupremeItemsFactory($this->mainItems[$index], $this->releaseWeek, $this->region);
                $models = $factory->build($this->http()->decodeResponse($response));
                foreach ($models as $supremeItem) {
                    $supremeItem->store();
                }
            },
            'rejected' => function (RequestException $reason, $index) {
                echo('failed ' . $index . ' ' . $reason . '\n');
            },
        ]);

        // Initiate the transfers and create a promise
        $promise = $pool->promise();

        // Force the pool of requests to complete.
        $promise->wait();
    }

    protected function buildRequests($mainItemsById)
    {
        $requests = [];
        foreach ($mainItemsById as $id => $mainItem) {
            $requests[$id] = new Request("GET", "/shop/$id.json");
        }
        return $requests;
    }

}