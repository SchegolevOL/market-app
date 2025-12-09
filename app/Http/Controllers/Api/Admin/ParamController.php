<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Api\Admin\Param\IndexRequest;
use App\Http\Requests\Api\Admin\Param\StoreRequest;
use App\Http\Requests\Api\Admin\Param\UpdateRequest;
use App\Http\Resources\Param\ParamResource;
use App\Models\Param;
use App\Services\ParamService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ParamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $data = $request->validated();
        $params = Param::filter($data)->get();
        return ParamResource::collection($params)->resolve();
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
        return ParamResource::make($param)->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Param $param)
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
        ParamService::delete($param);
        return response([
            'message'=>'Deleted successfully'
        ], Response::HTTP_OK);
    }
}
