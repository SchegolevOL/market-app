<?php

namespace App\Services;


use App\Models\Param;
use Illuminate\Support\Collection;

class ParamService
{
    public static function store(array $data): Param
    {
        return Param::create($data['param']);
    }

    public static function update(Param $param, array $data): Param
    {

        $param->update($data['param']);
        return $param->fresh();
    }

    public static function delete(Param $param)
    {
        $param->delete();
    }

    public static function indexByCategories(Collection $categoryChildren): Collection
    {

        // Вариант с коллекцией
        //----------------------
        $arr = collect([]);
        $categoryChildren->pluck('paramProducts')->each(function ($item) use ($arr) {


            $item->each(function ($i) use ($arr) {
                $arr->push($i);
            });
        });
        //-------------------------



        //Вариант с мвссивом
        //------------
//            $arr=[];
//        foreach ($categoryChildren->pluck('paramProducts') as $paramProduct){
//            $arr = array_merge($arr,$paramProduct->toArray());
//        }
//        $arr = collect($arr);
        //--------------
        $params = Param::whereIn('id', $arr->pluck('param_id'))->get();
        $arr = $arr->groupBy('param_id');
        foreach ($params as $param){
            $param->param_values = $arr[$param->id]->unique('value')->sortBy('value')->pluck('value')->toArray();
        }
        return $params;
    }




}
