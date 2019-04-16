<?php

namespace Modules\Creditcard\Http\Controllers;

use Foundation\Abstracts\Controller\Controller;
use Foundation\Responses\ApiResponse;
use Modules\Creditcard\Http\Requests\CreateCreditcardRequest;
use Modules\Creditcard\Http\Requests\DeleteCreditcardRequest;
use Modules\Creditcard\Http\Requests\FindCreditcardRequest;
use Modules\Creditcard\Http\Requests\IndexCreditcardRequest;
use Modules\Creditcard\Http\Requests\UpdateCreditcardRequest;
use Modules\Creditcard\Contracts\CreditcardServiceContract;
use Modules\Creditcard\Transformers\CreditcardTransformer;

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
        return CreditcardTransformer::collection($this->service->getByUserId(get_authenticated_user_id()));
    }

    /**
     * Store a newly created Creditcard in storage.
     */
    public function store(CreateCreditcardRequest $request)
    {
        $creditcard = $this->service->create($this->injectUserId($request));
        return CreditcardTransformer::resource($creditcard);
    }

    /**
     * Update a Creditcard.
     *
     * @param UpdateCreditcardRequest $request
     * @param $id
     */
    public function update(UpdateCreditcardRequest $request, $id)
    {
        $creditcard = $this->service->resolve($id);

        $this->exists($creditcard);
        $this->hasAccess($creditcard);
        $creditcard = $this->service->update($id, $request->toArray());

        return CreditcardTransformer::resource($creditcard);
    }

    /**
     * Show the specified resource.
     *
     * @param FindCreditcardRequest $request
     * @param $id
     */
    public function show(FindCreditcardRequest $request ,$id)
    {
        $creditcard = $this->service->resolve($id);

        $this->exists($creditcard);
        $this->hasAccess($creditcard);

        return CreditcardTransformer::resource($creditcard);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteCreditcardRequest $request, $id)
    {
        $creditcard = $this->service->resolve($id);

        $this->exists($creditcard);
        $this->hasAccess($creditcard);

        $this->service->delete($creditcard);

        return ApiResponse::deleted();
    }
}
