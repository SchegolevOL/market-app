<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Product\IndexRequest;
use App\Http\Requests\Api\Admin\Product\StoreRequest;
use App\Http\Requests\Api\Admin\Product\UpdateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $data = $request->validated();
        $products = Product::filter($data)->get();
        return ProductResource::collection($products)->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validationData();
        $product = ProductService::store($data);
        return ProductResource::make($product)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return ProductResource::make($product)->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Product $product)
    {
        $date = $request->validationData();
        ProductService::update($product, $date);
        return ProductResource::make($product)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        ProductService::delete($product);
        return response([
            'message' => 'Product deleted successfully'
        ], Response::HTTP_OK);
    }
}

