<?php


namespace Modules\Supreme\Parser;

use Modules\Supreme\Abstracts\SupremeParser;
use Modules\Supreme\Factory\SupremeItemsFactory;

class SupremeProductParser extends SupremeParser
{

    public function parse(int $id, SupremeItemsFactory $factory)
    {
        $http = $this->http();
        return $this->requestAsync("/shop/$id.json", function ($response) use($http,$factory) {
            $models = $factory->build($http->decodeResponse($response));
            foreach($models as $supremeItem){
                $supremeItem->store();
            }
            return $models;
        });
    }

    protected function request(string $route){
        return $this->http()->request($route);
    }

}