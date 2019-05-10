<?php


namespace Modules\Lookbook\Parsers;


use Storage;
use Supreme\Parser\SupremeParser;
use Supreme\Parser\SupremeProductParser;

class SupremeLookbookProductsParser
{

    protected $allItemsRoute;

    /**
     * SupremeLookbookProductsParser constructor.
     * @param $allItemsRoute
     */
    public function __construct($allItemsRoute)
    {
        $this->allItemsRoute = $allItemsRoute;
    }


    protected function getAllProductRoutes(){
        $parser = new SupremeParser($this->allItemsRoute);
        return $parser->getProductRoutes();
    }

    public function parse(){

        foreach ($this->getAllProductRoutes() as $productRoute) {
            try {
                $parsedProducts = (new SupremeProductParser($productRoute))->parse();
                $category = $this->extractCategory($productRoute);
                if ($parsedProducts !== null && ($this->getModel()::where('title', $parsedProducts[0]['title'])->first() === null)) {
                    $products = $this->transformProducts($parsedProducts,$category);
                    $model = $this->getModel()::create($products);
                    echo "parsed $model->title sleeping for $this->delay second(s) \n";
                }
            } catch (\Throwable $e) {
                echo "exception error: " . get_class($e) . " " . $e->getCode() . " " . $e->getMessage();
            }
            sleep($this->delay);
        }
        Storage::disk('local')->put('lookbooks/' . $this->getModel()::getSeasonName() . '.json', json_encode($this->getModel()::all()->toArray(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
}