<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;

class CategoryController extends Controller
{
    public function productIndex(Category $category)
    {
        $bredCrumbs = CategoryResource::collection(CategoryService::getCategoryParents($category)->reverse())->resolve();

        $categoryChildren = CategoryService::getCategoryChildren($category);
        $category = CategoryResource::make($category)->resolve();
        $products = ProductResource::collection(ProductService::indexByCategories($categoryChildren))->resolve();
        return inertia('Client/Category/ProductIndex', compact('products', 'bredCrumbs', 'category'));
    }
}
