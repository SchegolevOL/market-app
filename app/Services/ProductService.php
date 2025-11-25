<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;


class ProductService
{


    public static function store(array $data):Product
    {
        $product = Product::create($data['product']);
        ImageService::storeBatch($product, $data);
        return $product;
    }

    public static function update(Product $product, array $data):Product
    {
        $product->update($data['product']);
        ImageService::storeBatch($product, $data);
        return $product->fresh();
    }

    public static function delete(Product $product)
    {
        $images = $product->images;
        try {
            DB::beginTransaction();
            $product->delete();
            DB::commit();

        }catch (\Exception $exception){
            DB::rollBack();
        }

        foreach ($images as $image) {
            ImageService::destroy($image);
        }

    }
}
