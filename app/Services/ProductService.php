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

        $products = Product::byCategories($categoryChildren)->filter($data);
        return $products->distinct()->get();
    }

    public static function replicate(Product $product):Product
    {


        try {
            DB::beginTransaction();
            $cloneProduct = $product->replicate();
            $cloneProduct->article = $cloneProduct->article.fake()->randomNumber(4);
            $cloneProduct->parent_id = $product->id;
            $cloneProduct->push();

            ImageService::replicateBatch($product,$cloneProduct);
            ParamProductService::replicateBatch($product,$cloneProduct);
            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500, $exception->getMessage());
        }


        return $cloneProduct;
    }

}
