<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductWithGroupedParamResource;
use App\Models\Product;
use App\Services\CategoryService;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $products = ProductResource::collection($products)->resolve();

        return inertia('Client/Product/Index', compact('products'));
    }

    public function show(Product $product)
    {
        $bredCrumbs = CategoryService::getCategoryParents($product->category);
        $bredCrumbs = CategoryResource::collection($bredCrumbs->push($product->category))->resolve();

        $product = ProductWithGroupedParamResource::make($product)->resolve();
        return inertia('Client/Product/Show', compact('product', 'bredCrumbs'));
    }
}
