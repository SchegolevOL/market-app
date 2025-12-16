<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $products = ProductResource::collection($products)->resolve();
        return inertia('Client/Product/Index', compact('products'));
    }
}
