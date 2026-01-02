<?php

namespace App\Services;

use App\Models\ParamProduct;
use App\Models\Product;

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
}
