<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductGroup\IndexRequest;
use App\Http\Requests\Admin\ProductGroup\StoreRequest;
use App\Http\Requests\Admin\ProductGroup\UpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\ProductGroup\ProductGroupResource;
use App\Models\Category;
use App\Models\ProductGroup;
use App\Services\ProductGroupService;
use Illuminate\Http\Response;


class ProductGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $data = $request->validated();
        $productGroups = ProductGroup::filter($data)->get();
        $productGroups = ProductGroupResource::collection($productGroups)->resolve();
        if ($request->wantsJson()) {
            return $productGroups;
        }
        return inertia("Admin/ProductGroup/Index", ["productGroups" => $productGroups]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return inertia('Admin/ProductGroup/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        ;
        $data = $request->validated();
        $productGroup = ProductGroupService::store($data);

        return ProductGroupResource::make($productGroup)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductGroup $productGroup)
    {
        $productGroup = ProductGroupResource::make($productGroup)->resolve();
        return inertia('Admin/ProductGroup/Show', compact('productGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductGroup $productGroup)
    {
        $productGroup = ProductGroupResource::make($productGroup)->resolve();
        return inertia('Admin/ProductGroup/Edit', compact('productGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, ProductGroup $productGroup)
    {
        $data = $request->validated();
        $productGroup = ProductGroupService::update($productGroup, $data);
        return ProductGroupResource::make($productGroup)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductGroup $productGroup)
    {
        $productGroup->delete();
        return response([
            'message' => 'ProductGroup deleted successfully'
        ], Response::HTTP_OK);
    }
}
