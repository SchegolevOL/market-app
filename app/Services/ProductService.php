<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;


class ProductService
{


    public static function store(array $data): Product
    {
        $product = Product::create($data['product']);
        ProductService::attachBatchParams($product, $data['params']);
        ImageService::storeBatch($product, $data['images']);

        return $product;
    }

    public static function update(Product $product, array $data): Product
    {

        $product->update($data['product']);

        ImageService::storeBatch($product, $data['images']);
        ProductService::syncBatchParams($product, $data['params']);
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


}
