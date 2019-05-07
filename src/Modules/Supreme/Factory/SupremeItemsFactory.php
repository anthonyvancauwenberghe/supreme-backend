<?php


namespace Modules\Supreme\Factory;

use Modules\Supreme\Models\SupremeItem;

class SupremeItemsFactory
{

    protected $mainItem;

    protected $releaseWeek;

    protected $region;

    public function __construct(array $mainItem, string $releaseWeek, string $region)
    {
        $this->mainItem = $mainItem;
        $this->releaseWeek = $releaseWeek;
        $this->region = $region;
    }


    /**
     * @param array $item
     * @return SupremeItem[]
     */
    public function build(array $item): array
    {
        $items = [];
        foreach ($item['styles'] as $style) {
            foreach ($style['sizes'] as $size) {
                $items[] = new SupremeItem(
                    $this->mainItem['id'],
                    $style['id'],
                    $size['id'],
                    $this->mainItem['name'],
                    $this->mainItem['category_name'],
                    round($this->mainItem['price'] / 100, 2),
                    $style['currency'],
                    $style['name'],
                    $size['name'],
                    $this->region,
                    $this->releaseWeek,
                    (bool)$size['stock_level']
                );
            }
        }
        return $items;
    }
}