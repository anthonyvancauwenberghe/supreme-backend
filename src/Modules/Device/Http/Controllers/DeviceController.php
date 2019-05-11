<?php

namespace Modules\Device\Http\Controllers;

use Foundation\Abstracts\Controller\Controller;
use Foundation\Responses\ApiResponse;
use Modules\Device\Http\Requests\CreateDeviceRequest;
use Modules\Device\Http\Requests\DeleteDeviceRequest;
use Modules\Device\Http\Requests\FindDeviceRequest;
use Modules\Device\Http\Requests\IndexDeviceRequest;
use Modules\Device\Http\Requests\UpdateDeviceRequest;
use Modules\Device\Contracts\DeviceServiceContract;
use Modules\Device\Transformers\DeviceTransformer;
use Modules\Device\Dtos\CreateDeviceData;
use Modules\Device\Dtos\UpdateDeviceData;

class DeviceController extends Controller
{
    /**
     * @var DeviceServiceContract
     */
    protected $service;

    /**
     * DeviceController constructor.
     *
     * @param $service
     */
    public function __construct(DeviceServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexDeviceRequest $request)
    {
        return DeviceTransformer::collection($this->service->fromUser($request->user()));
    }

    /**
     * Store a newly created Device in the database.
     */
    public function store(CreateDeviceRequest $request)
    {
        $device = $this->service->create(new CreateDeviceData($request), $request->user());
        return DeviceTransformer::resource($device);
    }

    /**
     * Update a Device.
     */
    public function update(UpdateDeviceRequest $request, $id)
    {
        $device = $this->service->find($id, $request->user());

        $this->exists($device);
        $this->hasAccess($device);
        $device = $this->service->update($id, $request->user(), new UpdateDeviceData($request));

        return DeviceTransformer::resource($device);
    }

    /**
     * Show the specified resource.
     */
    public function show(FindDeviceRequest $request ,$id)
    {
        $device = $this->service->find($id, $request->user());

        $this->exists($device);
        $this->hasAccess($device);

        return DeviceTransformer::resource($device);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteDeviceRequest $request, $id)
    {
        $device = $this->service->find($id, $request->user());

        $this->exists($device);
        $this->hasAccess($device);

        $this->service->delete($device);

        return ApiResponse::deleted();
    }
}
