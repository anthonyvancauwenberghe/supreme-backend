<?php

namespace Modules\License\Http\Controllers;

use Foundation\Abstracts\Controller\Controller;
use Foundation\Responses\ApiResponse;
use Modules\License\Http\Requests\DeleteLicenseRequest;
use Modules\License\Http\Requests\FindLicenseRequest;
use Modules\License\Http\Requests\IndexLicenseRequest;
use Modules\License\Http\Requests\UpdateLicenseRequest;
use Modules\License\Contracts\LicenseServiceContract;
use Modules\License\Transformers\LicenseTransformer;
use Modules\User\Entities\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LicenseController extends Controller
{
    /**
     * @var LicenseServiceContract
     */
    protected $service;

    /**
     * LicenseController constructor.
     *
     * @param $service
     */
    public function __construct(LicenseServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexLicenseRequest $request)
    {
        return LicenseTransformer::collection($this->service->fromUser($request->user()));
    }

    /**
     * Update a License.
     */
    public function transfer(UpdateLicenseRequest $request, $id)
    {
        $license = $this->service->find($id);

        $this->exists($license);
        $this->hasAccess($license);

        if($user = User::find($request->user_id) === null)
            throw new NotFoundHttpException("User not found");

        $license = $this->service->transfer($id, $user);

        return LicenseTransformer::resource($license);
    }

    /**
     * Show the specified resource.
     */
    public function show(FindLicenseRequest $request ,$id)
    {
        $license = $this->service->find($id);

        $this->exists($license);
        $this->hasAccess($license);

        return LicenseTransformer::resource($license);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteLicenseRequest $request, $id)
    {
        $license = $this->service->find($id);

        $this->exists($license);
        $this->hasAccess($license);

        $this->service->delete($license);

        return ApiResponse::deleted();
    }
}
