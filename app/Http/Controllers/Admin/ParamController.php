<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Param\ParamFilterTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Param\StoreRequest;
use App\Http\Resources\Param\ParamResource;
use App\Models\Param;
use App\Services\ParamService;
use Illuminate\Http\Response;

class ParamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $params = Param::all();

        $params =ParamResource::collection($params)->resolve();
        return inertia('Admin/Param/Index', compact('params'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filterTypes = ParamFilterTypeEnum::collection();
        return inertia('Admin/Param/Create', compact('filterTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validationData();
        $param = ParamService::store($data['param']);
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
        $param = ParamResource::make($param)->resolve();
        return inertia('Admin/Param/Edit', compact('param'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\App\Http\Requests\Admin\Param\UpdateRequest $request, Param $param)
    {
        $data = $request->validated();
        $param = ParamService::update($param, $data);
        return ParamResource::make($param)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Param $param)
    {
        $param->delete();
        return response([
            'message' => 'Param deleted successfully'
        ], Response::HTTP_OK);
    }
}
