<?php


namespace Modules\Lookbook\Jobs;

use Modules\Lookbook\Abstracts\LookbookParserJob;
use Modules\Lookbook\Entities\SpringSummer2019Lookbook;

class SpringSummer2019LookbookParserJob extends LookbookParserJob
{
    protected function getAllItemsRoute() :string
    {
        return "/previews/springsummer2019/all";
    }

    public function getModel(): string
    {
       return SpringSummer2019Lookbook::class;
    }


}