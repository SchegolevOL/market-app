<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Category\ProductIndexRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Param\ParamsWithValuesResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\ParamService;
use App\Services\ProductService;

class CategoryController extends Controller
{
    public function productIndex(Category $category, ProductIndexRequest $request)
    {
        $data = $request->validated();

        $categoryChildren = CategoryService::getCategoryChildren($category);
        $products = ProductResource::collection(ProductService::indexByCategories($categoryChildren, $data))->resolve();
        $params = ParamService::indexByCategories($categoryChildren);
        $params = ParamsWithValuesResource::collection($params)->resolve();

        if($request->wantsJson()){

            return $products;
        }

        $bredCrumbs = CategoryResource::collection(CategoryService::getCategoryParents($category))->resolve();


        $category = CategoryResource::make($category)->resolve();



        return inertia('Client/Category/ProductIndex', compact('products', 'bredCrumbs', 'category', 'params'));
    }
}
