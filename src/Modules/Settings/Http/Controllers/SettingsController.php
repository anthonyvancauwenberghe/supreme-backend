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
     * Update a Settings.
     */
    public function update(UpdateSettingsRequest $request, $id)
    {
        $settings = $this->service->find($id);

        $this->exists($settings);
        $this->hasAccess($settings);
        $settings = $this->service->update(new UpdateSettingsData($request), $user);

        return SettingsTransformer::resource($settings);
    }

}
