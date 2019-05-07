<?php


namespace Modules\Supreme\Parser;

use Modules\Supreme\Abstracts\SupremeParser;

class SupremeMobileStockParser extends SupremeParser
{
    public function parse() :array
    {
        return $this->request("/mobile_stock.json");
    }
}