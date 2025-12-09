<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\ProductGroup\StoreRequest;
use App\Http\Requests\Api\Admin\ProductGroup\UpdateRequest;
use App\Http\Resources\ProductGroup\ProductGroupResource;
use App\Models\ProductGroup;
use App\Services\ProductGroupService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductGroupResource::collection(ProductGroup::all())->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $date = $request->validated();
        $productGroup = ProductGroupService::store($date);
        return ProductGroupResource::make($productGroup)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductGroup $productGroup)
    {
        return ProductGroupResource::make($productGroup)->resolve();
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
        ProductGroupService::delete($productGroup);
        return response([
            'message' => 'product group deleted successfully'
        ], Response::HTTP_OK);
    }
}
