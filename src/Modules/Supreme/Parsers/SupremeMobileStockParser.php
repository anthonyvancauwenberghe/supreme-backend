<?php


namespace Modules\Supreme\Parsers;

use Modules\Supreme\Abstracts\SupremeParser;

class SupremeMobileStockParser extends SupremeParser
{
    public function parse() :array
    {
        return $this->request("/mobile_stock.json");
    }
}