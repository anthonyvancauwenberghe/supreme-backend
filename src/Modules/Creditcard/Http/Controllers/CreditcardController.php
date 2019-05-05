<?php

namespace Modules\Creditcard\Http\Controllers;

use Foundation\Abstracts\Controller\Controller;
use Foundation\Responses\ApiResponse;
use Modules\Creditcard\Dtos\CreateCreditcardData;
use Modules\Creditcard\Dtos\UpdateCreditcardData;
use Modules\Creditcard\Http\Requests\CreateCreditcardRequest;
use Modules\Creditcard\Http\Requests\DeleteCreditcardRequest;
use Modules\Creditcard\Http\Requests\FindCreditcardRequest;
use Modules\Creditcard\Http\Requests\IndexCreditcardRequest;
use Modules\Creditcard\Http\Requests\UpdateCreditcardRequest;
use Modules\Creditcard\Contracts\CreditcardServiceContract;
use Modules\Creditcard\Transformers\CreditcardTransformer;
use Modules\Creditcard\Transformers\HiddenCreditcardTransformer;

class CreditcardController extends Controller
{
    /**
     * @var CreditcardServiceContract
     */
    protected $service;

    /**
     * CreditcardController constructor.
     *
     * @param $service
     */
    public function __construct(CreditcardServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexCreditcardRequest $request)
    {
        return HiddenCreditcardTransformer::collection($this->service->fromUser($request->user()));
    }

    /**
     * Store a newly created Creditcard in the database.
     */
    public function store(CreateCreditcardRequest $request)
    {
        $creditcard = $this->service->create(new CreateCreditcardData($request), $request->user());
        return HiddenCreditcardTransformer::resource($creditcard);
    }

    /**
     * Update a Creditcard.
     */
    public function update(UpdateCreditcardRequest $request, $id)
    {
        $creditcard = $this->service->find($id);

        $this->exists($creditcard);
        $this->hasAccess($creditcard);
        $creditcard = $this->service->update($id, new UpdateCreditcardData($request));

        return HiddenCreditcardTransformer::resource($creditcard);
    }

    /**
     * Show the specified resource.
     *
     */
    public function show(FindCreditcardRequest $request, $id)
    {
        $creditcard = $this->service->find($id);

        $this->exists($creditcard);
        $this->hasAccess($creditcard);

        return CreditcardTransformer::resource($creditcard);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteCreditcardRequest $request, $id)
    {
        $creditcard = $this->service->find($id);

        $this->exists($creditcard);
        $this->hasAccess($creditcard);

        $this->service->delete($creditcard);

        return ApiResponse::deleted();
    }
}
