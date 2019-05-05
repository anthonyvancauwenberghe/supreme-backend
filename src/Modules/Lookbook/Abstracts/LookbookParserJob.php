<?php


namespace Modules\Lookbook\Abstracts;

use Foundation\Abstracts\Jobs\Job;
use Storage;
use Supreme\Parser\SupremeParser;
use Supreme\Parser\SupremeProductParser;

abstract class LookbookParserJob extends Job
{
    public $timeout = 600;

    public $delay;

    /**
     * LookbookParserJob constructor.
     * @param int $timeout
     */
    public function __construct(int $delay = 3)
    {
        $this->delay = $delay;
    }


    protected abstract function getAllItemsRoute(): string;

    public abstract function getModel(): string;


    public function handle()
    {
        $parser = new SupremeParser($this->getAllItemsRoute());
        $productUrls = $parser->getProductRoutes();

        foreach ($productUrls as $productRoute) {
            try {
                $parsedProducts = (new SupremeProductParser($productRoute))->parse();
                $category = $this->extractCategory($productRoute);
                if ($parsedProducts !== null && ($this->getModel()::where('title', $parsedProducts[0]['title'])->first() === null)) {
                    $products = $this->transformProducts($parsedProducts);
                    $products = array_merge($products, ["category" => $category]);
                    $model = $this->getModel()::create($products);
                    echo "parsed $model->title sleeping for $this->delay second(s) \n";
                }
            } catch (\Throwable $e) {
                echo "exception error: " . get_class($e) . " " . $e->getCode() . " " . $e->getMessage();
            }
            sleep($this->delay);
        }
        Storage::disk('local')->put('lookbooks/' . $this->getModel()::getSeasonName() . '.json', json_encode($this->getModel()::all()->toArray(), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
    }

    protected function transformProducts(array $products)
    {
        $title = $products[0]['title'];
        $caption = $products[0]['caption'];
        $styles = [];
        $colors = [];

        foreach ($products as $product) {
            $color = str_replace(" ","_",strtolower($product['color']));
            if($color === "")
                $color = "unknown";
            if (!in_array($color, $colors) && $color !== "group" && $color !== "group_reshoot")
                $colors[] = $color;
            $styles[$color][] = str_replace("//", "https://", $product['imageUrl']);
        }

        return [
            "title" => $title,
            "caption" => $caption,
            "images" => $styles,
            "colors" => $colors
        ];
    }

    protected function extractCategory($producturl)
    {
        $producturl = strtolower($producturl);
        $pieces = explode('/', $producturl);
        $categories = [
            "jackets",
            "shirts",
            "tops-sweaters",
            "sweatshirts",
            "pants",
            "shorts",
            "t-shirts",
            "hats",
            "bags",
            "skate",
            "accessories"
        ];
        foreach ($categories as $category) {
            if (in_array($category, $pieces))
                return $category;
        }
        return "unknown";
    }
}