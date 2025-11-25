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

        foreach ($data['images'] as $image) {

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


}
