<?php

namespace Modules\Order\Http\Controllers;

use Foundation\Abstracts\Controller\Controller;
use Foundation\Responses\ApiResponse;
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
        $order = $this->service->create(new CreateOrderData($request), $request->user());
        return OrderTransformer::resource($order);
    }
}
