<?php


namespace Modules\Supreme\Models;

use Cache;
use Carbon\Carbon;
use Modules\Supreme\Entities\SupremeItemDBModel;
use Modules\Supreme\Events\SupremeItemOutOfStockEvent;
use Modules\Supreme\Events\SupremeItemReleasedEvent;
use Modules\Supreme\Events\SupremeItemRestockedEvent;

class SupremeItem
{
    public $item_id;

    public $styleId;

    public $sizeId;

    public $name;

    public $description;

    public $category;

    public $price;

    public $currency;

    public $style;

    public $size;

    public $region;

    public $releaseWeek;

    public $stock;


    public function __construct(int $id, int $styleId, int $sizeId, string $name, string $category, float $price, string $currency, string $style, string $size, string $region, string $releaseWeek, bool $stock)
    {
        $this->item_id = $id;
        $this->styleId = $styleId;
        $this->sizeId = $sizeId;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
        $this->currency = $currency;
        $this->style = $style;
        $this->size = $size;
        $this->region = $region;
        $this->releaseWeek = $releaseWeek;
        $this->stock = $stock;
    }

    public function store()
    {
        if (($cachedModel = self::findBySizeId($this->item_id, $this->sizeId)) === null) {
            //NEW ITEM RELEASED
            $this->storeDatabase();
            $this->cacheItem();
            event(new SupremeItemReleasedEvent($this));
        } elseif ($cachedModel->stock !== $this->stock) {
            //STOCK LEVELS DIFFER
            $this->cacheItem();

            if ($this->stock) {
                event(new SupremeItemRestockedEvent($this));
            } else {
                event(new SupremeItemOutOfStockEvent($this));
            }
        } else {
            //NOTHING CHANGED
        }
    }

    protected function cacheItem()
    {
        Cache::put("supreme:items:$this->item_id:size:$this->sizeId", $this, Carbon::now()->addWeek());
    }

    protected function storeDatabase()
    {
        if (SupremeItemDBModel::where('size_id', $this->sizeId)
                ->where('item_id',$this->item_id)
                ->first() === null) {
            $data = $this->toArray();
            unset($data['stock']);
            SupremeItemDBModel::create($data);
        }
    }

    public static function findBySizeId($id, $sizeId): ?self
    {
        return Cache::get("supreme:items:$id:size:$sizeId");
    }

    public function toArray()
    {
        return [
            "item_id" => $this->item_id,
            "style_id" => $this->styleId,
            "size_id" => $this->sizeId,
            "name" => $this->name,
            "category" => $this->category,
            "price" => $this->price,
            "currency" => $this->currency,
            "style" => $this->style,
            "size" => $this->size,
            "region" => $this->region,
            "release_week" => $this->releaseWeek,
            "stock" => $this->stock
        ];
    }
}
