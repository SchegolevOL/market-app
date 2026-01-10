<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Param\ParamFilterTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Param\IndexRequest;
use App\Http\Requests\Admin\Param\StoreRequest;
use App\Http\Requests\Admin\Param\UpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Param\ParamResource;
use App\Models\Category;
use App\Models\Param;
use App\Services\ParamService;
use Illuminate\Http\Response;

class ParamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $data= $request->validated();

        $params = Param::filter($data)->get();
        $params =ParamResource::collection($params)->resolve();
        if ($request->wantsJson()) {

            return $params;

        }
        return inertia('Admin/Param/Index', compact('params'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filterTypes = ParamFilterTypeEnum::collection();
        $categories = CategoryResource::collection(Category::whereNull('parent_id')->get())->resolve();
        return inertia('Admin/Param/Create', compact('filterTypes', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validationData();
        $param = ParamService::store($data);
        return ParamResource::make($param)->resolve();
    }

    /**
     * Display the specified resource.
     */
    public function show(Param $param)
    {
        $param = ParamResource::make($param)->resolve();
        return inertia('Admin/Param/Show', compact('param'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Param $param)
    {
        $filterTypes = ParamFilterTypeEnum::collection();
        $param = ParamResource::make($param)->resolve();
        $categories = CategoryResource::collection(Category::whereNull('parent_id')->get())->resolve();
        return inertia('Admin/Param/Edit', compact('param', 'filterTypes', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Param $param)
    {

        $data = $request->validationData();

        $param = ParamService::update($param, $data);
        return ParamResource::make($param)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Param $param)
    {
        ParamService::delete($param);
        return response([
            'message' => 'Param deleted successfully'
        ], Response::HTTP_OK);
    }
}
