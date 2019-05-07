<?php

namespace Modules\Settings\Http\Controllers;

use Foundation\Abstracts\Controller\Controller;
use Foundation\Responses\ApiResponse;
use Modules\Settings\Http\Requests\CreateSettingsRequest;
use Modules\Settings\Http\Requests\DeleteSettingsRequest;
use Modules\Settings\Http\Requests\FindSettingsRequest;
use Modules\Settings\Http\Requests\IndexSettingsRequest;
use Modules\Settings\Http\Requests\UpdateSettingsRequest;
use Modules\Settings\Contracts\SettingsServiceContract;
use Modules\Settings\Transformers\SettingsTransformer;
use Modules\Settings\Dtos\CreateSettingsData;
use Modules\Settings\Dtos\UpdateSettingsData;

class SettingsController extends Controller
{
    /**
     * @var SettingsServiceContract
     */
    protected $service;

    /**
     * SettingsController constructor.
     *
     * @param $service
     */
    public function __construct(SettingsServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexSettingsRequest $request)
    {
        return SettingsTransformer::collection($this->service->fromUser($request->user()));
    }

    /**
     * Store a newly created Settings in the database.
     */
    public function store(CreateSettingsRequest $request)
    {
        $settings = $this->service->create(new CreateSettingsData($request), $request->user());
        return SettingsTransformer::resource($settings);
    }

    /**
     * Update a Settings.
     */
    public function update(UpdateSettingsRequest $request, $id)
    {
        $settings = $this->service->find($id);

        $this->exists($settings);
        $this->hasAccess($settings);
        $settings = $this->service->update($id, new UpdateSettingsData($request));

        return SettingsTransformer::resource($settings);
    }

    /**
     * Show the specified resource.
     */
    public function show(FindSettingsRequest $request ,$id)
    {
        $settings = $this->service->find($id);

        $this->exists($settings);
        $this->hasAccess($settings);

        return SettingsTransformer::resource($settings);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteSettingsRequest $request, $id)
    {
        $settings = $this->service->find($id);

        $this->exists($settings);
        $this->hasAccess($settings);

        $this->service->delete($settings);

        return ApiResponse::deleted();
    }
}
