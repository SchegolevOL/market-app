<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Cast\Object_;

class ImageService
{
    public static function storeBatch(Model $model, array $data)
    {

        foreach ($data as $image) {

            $model->images()->create([
                'path' => Storage::disk('public')->put('images/' . strtolower(class_basename($model)), $image),
            ]);
        }
    }

    public static function destroy(Image $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();
    }

    public static function replicateBatch(Product $product, Product $cloneProduct)
    {

        foreach ($product->images as $image) {

            $path = 'images/'.strtolower(class_basename($product)).'/'.self::getUniqueImageName($image->path);

            Storage::disk('public')->copy( $image->path, $path);
            $cloneProduct->images()->create([
                'path' => $path,
            ]);
        }

    }

    private static function getUniqueImageName(String $path)
    {
        $extension = array_slice(explode('.', $path),-1);
        $name = bin2hex(random_bytes(16));
        return $name.'.'.$extension[0];
    }

}
