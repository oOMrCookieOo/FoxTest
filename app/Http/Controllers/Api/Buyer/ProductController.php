<?php

namespace App\Http\Controllers\Api\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = Product::query()
            ->active()
            ->when($request->filled('search'),function ($query)use ($request){
                $query->search($request->search);
            })
            ->when($request->filled('category'),function ($query) use ($request){
                $query->whereRelation('category','id','=',$request->category);
            })
            ->latest()
            ->withWhereHas('category')
            ->paginate(12);
        return ProductResource::collection($data);
    }
}
