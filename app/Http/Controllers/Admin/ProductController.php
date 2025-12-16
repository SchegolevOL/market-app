<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\IndexRequest;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Param\ParamResource;
use App\Http\Resources\Product\ProductCategoryResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\ProductGroup\ProductGroupResource;
use App\Models\Category;
use App\Models\Param;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\ProductParent;
use App\Services\ProductService;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $data = $request->validationData();
        $products = Product::filter($data)->whereNull('parent_id')->paginate($data['per_page'], '*', 'page', $data['page']);
        $products =ProductResource::collection($products);
        if ($request->wantsJson()) {
            return $products;
        }
        return inertia('Admin/Product/Index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $categories =CategoryResource::collection($categories)->resolve();
        $params = Param::all();
        $params =ParamResource::collection($params)->resolve();
        $productGroups = ProductGroup::all();
        $productGroups =ProductGroupResource::collection($productGroups)->resolve();

        return inertia('Admin/Product/Create', compact('categories','productGroups', 'params'));
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
        $product = ProductCategoryResource::make($product)->resolve();
        return inertia('Admin/Product/Show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $categories =CategoryResource::collection($categories)->resolve();
        $params = Param::all();
        $params =ParamResource::collection($params)->resolve();
        $productGroups = ProductGroup::all();
        $productGroups =ProductGroupResource::collection($productGroups)->resolve();
        $product = ProductResource::make($product)->resolve();

        return inertia('Admin/Product/Edit', compact('product', 'categories','productGroups', 'params'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Product $product)
    {

        $data = $request->validationData();

        $product = ProductService::update($product, $data);
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

    public function createChild(Product $product)
    {
        $categories = Category::all();
        $categories =CategoryResource::collection($categories)->resolve();
        $params = Param::all();
        $params =ParamResource::collection($params)->resolve();
        $productGroups = ProductGroup::all();
        $productGroups =ProductGroupResource::collection($productGroups)->resolve();
        $product = ProductResource::make($product)->resolve();
        return inertia('Admin/Product/CreateChild', compact('categories','productGroups', 'params', 'product'));
    }

    public function indexChild(Product $product)
    {
        return ProductResource::collection($product->children)->resolve();

    }
}
