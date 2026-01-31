<?php

namespace App\Services;

use App\Models\ParamProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ParamProductService
{
    public static function replicateBatch(Product $product, Product $cloneProduct)
    {
        foreach ($product->paramProduct as $param) {
            $cloneParamProduct = $param->replicate();
            $cloneParamProduct->product_id = $cloneProduct->id;
            $cloneParamProduct->push();
        }
    }
    public static function getGroupedByParamArray(Product $product): array
    {
       $paramProducts = ParamProduct::getGroupedByParams($product)->get()->groupBy('param_id')->map(function ($item) {

                return[
                    'title' => $item->first()->title,
                    'data' => $item->toArray(),
                ];
            });

       return array_values($paramProducts->toArray());
    }
}
