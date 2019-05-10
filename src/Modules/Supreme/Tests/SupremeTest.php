<?php


namespace Modules\Supreme\Tests;


use Foundation\Abstracts\Tests\TestCase;
use Modules\Supreme\Entities\SupremeItemDBModel;
class SupremeTest extends TestCase
{
    public function testSupremeApiGetting()
    {
        \Artisan::call('supreme:parse', ['region' => 'EU']);

        $items = SupremeItemDBModel::all();

        $categories = [];

        foreach ($items as $item) {
            if (!array_key_exists($item->category, $categories))
                $categories[$item->category][] = $item->size;
            elseif (!in_array($item->size, $categories[$item->category]))
                $categories[$item->category][] = $item->size;
        }

        \Storage::disk('local')
            ->put('categories.json',
                json_encode($categories,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
}