<?php

namespace Modules\User\Http\Controllers;

use Foundation\Abstracts\Controller\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\User\Contracts\UserServiceContract;
use Modules\User\Services\UserService;
use Modules\User\Transformers\UserTransformer;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected $service;

    /**
     * UserController constructor.
     *
     * @param $service
     */
    public function __construct(UserServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index()
    {
        return UserTransformer::collection($this->service->all()->load('roles'));
    }

    /**
     * Show the specified resource.
     *
     * @return UserTransformer
     */
    public function show()
    {
        return UserTransformer::resource(get_authenticated_user());
    }

    /**
     * Update the roles in storage.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->service->setRoles($id, $request->roles);

        return \response()->json('success');
    }
}
