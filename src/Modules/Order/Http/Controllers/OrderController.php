<?php

namespace Modules\Order\Http\Controllers;

use Foundation\Abstracts\Controller\Controller;
use Foundation\Responses\ApiResponse;
use Illuminate\Database\Eloquent\Collection;
use Modules\Order\Http\Requests\CreateOrderRequest;
use Modules\Order\Http\Requests\DeleteOrderRequest;
use Modules\Order\Http\Requests\FindOrderRequest;
use Modules\Order\Http\Requests\IndexOrderRequest;
use Modules\Order\Http\Requests\UpdateOrderRequest;
use Modules\Order\Contracts\OrderServiceContract;
use Modules\Order\Transformers\OrderTransformer;
use Modules\Order\Dtos\CreateOrderData;
use Modules\Order\Dtos\UpdateOrderData;

class OrderController extends Controller
{
    /**
     * @var OrderServiceContract
     */
    protected $service;

    /**
     * OrderController constructor.
     *
     * @param $service
     */
    public function __construct(OrderServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexOrderRequest $request)
    {
        $data = $this->service->fromUser($request->user());
        return OrderTransformer::collection($data);
    }

    /**
     * Store a newly created Order in the database.
     */
    public function store(CreateOrderRequest $request)
    {
        if ($request->has('items') && is_array($request->items) && !empty($request->items)) {
            $order = $request->all();
            unset($order['items']);
            $orders = new Collection();
            foreach ($request->items as $item) {
                $order = array_merge($order, $item);
                $orders->add($this->service->create(new CreateOrderData($order), $request->user()));
            }
            return OrderTransformer::collection($orders);
        } else {
            $order = $this->service->create(new CreateOrderData($request), $request->user());
            return OrderTransformer::resource($order);
        }

    }
}
