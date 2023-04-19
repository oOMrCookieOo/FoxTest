<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    protected ProductRepository $repository;

    /**
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {

        $data = Product::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->search($request->search);
            })
            ->withWhereHas('category')
            ->latest()
            ->paginate($request->perPage ?? 5);
        return ProductResource::collection($data);
    }

    public function store(StoreProductRequest $request){
        $this->authorize('product-create');
        $this->repository->newWithFile($request);
        return $this->respondWithSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
         $this->repository->destroy($id);
         return $this->respondWithSuccess();
    }

}
