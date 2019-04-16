<?php

namespace Modules\Shipping\Http\Controllers;

use Foundation\Abstracts\Controller\Controller;
use Foundation\Responses\ApiResponse;
use Modules\Shipping\Http\Requests\CreateShippingRequest;
use Modules\Shipping\Http\Requests\DeleteShippingRequest;
use Modules\Shipping\Http\Requests\FindShippingRequest;
use Modules\Shipping\Http\Requests\IndexShippingRequest;
use Modules\Shipping\Http\Requests\UpdateShippingRequest;
use Modules\Shipping\Contracts\ShippingServiceContract;
use Modules\Shipping\Transformers\ShippingTransformer;

class ShippingController extends Controller
{
    /**
     * @var ShippingServiceContract
     */
    protected $service;

    /**
     * ShippingController constructor.
     *
     * @param $service
     */
    public function __construct(ShippingServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexShippingRequest $request)
    {
        return ShippingTransformer::collection($this->service->getByUserId(get_authenticated_user_id()));
    }

    /**
     * Store a newly created Shipping in storage.
     */
    public function store(CreateShippingRequest $request)
    {
        $shipping = $this->service->create($this->injectUserId($request));
        return ShippingTransformer::resource($shipping);
    }

    /**
     * Update a Shipping.
     *
     * @param UpdateShippingRequest $request
     * @param $id
     */
    public function update(UpdateShippingRequest $request, $id)
    {
        $shipping = $this->service->resolve($id);

        $this->exists($shipping);
        $this->hasAccess($shipping);
        $shipping = $this->service->update($id, $request->toArray());

        return ShippingTransformer::resource($shipping);
    }

    /**
     * Show the specified resource.
     *
     * @param FindShippingRequest $request
     * @param $id
     */
    public function show(FindShippingRequest $request ,$id)
    {
        $shipping = $this->service->resolve($id);

        $this->exists($shipping);
        $this->hasAccess($shipping);

        return ShippingTransformer::resource($shipping);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteShippingRequest $request, $id)
    {
        $shipping = $this->service->resolve($id);

        $this->exists($shipping);
        $this->hasAccess($shipping);

        $this->service->delete($shipping);

        return ApiResponse::deleted();
    }
}
