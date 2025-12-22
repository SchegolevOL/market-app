<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class ProductService
{


    public static function store(array $data): Product
    {
        try {
            DB::beginTransaction();
            $product = Product::create($data['product']);
            ProductService::attachBatchParams($product, $data['params']);
            ImageService::storeBatch($product, $data['images']);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500, $exception->getMessage());
        }
        return $product;
    }

    public static function update(Product $product, array $data): Product
    {
        try {
            DB::beginTransaction();
            $product->update($data['product']);
            ImageService::storeBatch($product, $data['images']);
            ProductService::syncBatchParams($product, $data['params']);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500, $exception->getMessage());
        }

        return $product->fresh();
    }

    public static function delete(Product $product)
    {

        try {
            DB::beginTransaction();
            $product->delete();
            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
        }

    }

    public static function attachBatchParams(Product $product, array $data)
    {
        foreach ($data as $param) {
            $product->params()->attach($param['id'], ['value' => $param['value']]);
        }
    }

    public static function syncBatchParams(Product $product, array $data)
    {
        $product->params()->detach();
        ProductService::attachBatchParams($product, $data);
    }

    public static function indexByCategories(Collection $categoryChildren, array $data)
    {
        $products = Product::byCategories($categoryChildren);


        if (isset($data['filters']['integer']['from'])) {
            $products->whereHas('paramProduct', function ($query) use ($data) {
                foreach ($data['filters']['integer']['from'] as $key=>$value) {
                    $query->where('param_id', $key)->whereRaw('CAST(value AS INT) >= ?',  $value);
                }
            });
        }
        if (isset($data['filters']['integer']['to'])) {
            $products->whereHas('paramProduct', function ($query) use ($data) {
                foreach ($data['filters']['integer']['to'] as $key=>$value) {
                    $query->where('param_id', $key)->whereRaw('CAST(value AS INT) <= ?',  $value);
                }
            });
        }
        if (isset($data['filters']['checkbox'])) {
            $products->whereHas('paramProduct', function ($query) use ($data) {
                foreach ($data['filters']['checkbox'] as $key=>$value) {
                    $query->where('param_id', $key)->whereIn('value', $value);
                }
            });
        }
        if (isset($data['filters']['select'])) {
            $products->whereHas('paramProduct', function ($query) use ($data) {
                foreach ($data['filters']['select'] as $key=>$value) {
                    $query->where('param_id', $key)->where('value',  $value);
                }
            });
        }

        return $products->distinct()->get();
    }

}
