<?php

namespace Modules\Wishlist\Http\Controllers;

use Foundation\Abstracts\Controller\Controller;
use Foundation\Responses\ApiResponse;
use Modules\Wishlist\Http\Requests\CreateWishlistRequest;
use Modules\Wishlist\Http\Requests\DeleteWishlistRequest;
use Modules\Wishlist\Http\Requests\FindWishlistRequest;
use Modules\Wishlist\Http\Requests\IndexWishlistRequest;
use Modules\Wishlist\Http\Requests\UpdateWishlistRequest;
use Modules\Wishlist\Contracts\WishlistServiceContract;
use Modules\Wishlist\Transformers\WishlistTransformer;
use Modules\Wishlist\Dtos\CreateWishlistData;
use Modules\Wishlist\Dtos\UpdateWishlistData;

class WishlistController extends Controller
{
    /**
     * @var WishlistServiceContract
     */
    protected $service;

    /**
     * WishlistController constructor.
     *
     * @param $service
     */
    public function __construct(WishlistServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexWishlistRequest $request)
    {
        return WishlistTransformer::collection($this->service->fromUser($request->user()));
    }

    /**
     * Store a newly created Wishlist in the database.
     */
    public function store(CreateWishlistRequest $request)
    {
        $wishlist = $this->service->create(new CreateWishlistData($request), $request->user());
        return WishlistTransformer::resource($wishlist);
    }

    /**
     * Show the specified resource.
     */
    public function show(FindWishlistRequest $request ,$id)
    {
        $wishlist = $this->service->find($id);

        $this->exists($wishlist);
        $this->hasAccess($wishlist);

        return WishlistTransformer::resource($wishlist);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteWishlistRequest $request, $id)
    {
        $wishlist = $this->service->find($id);

        $this->exists($wishlist);
        $this->hasAccess($wishlist);

        $this->service->delete($wishlist);

        return ApiResponse::deleted();
    }
}
