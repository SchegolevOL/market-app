<?php

namespace App\Models;

use App\Services\CategoryService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use function Laravel\Prompts\warning;

class Category extends Model
{
    public function getParentAttribute()
    {
        $parent=Category::query()->where('id',$this->parent_id)->first();

        return $parent?$parent->title:'Main Category';
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function getImageUrlsAttribute()
    {
        $imageUrlsFullPath=[];
        $imageUrls = $this->images()->get()->pluck('path')->toArray();
        foreach ($imageUrls as $imageUrl) {
            $imageUrlsFullPath[]=Storage::disk('public')->url($imageUrl);
        }

        return $imageUrlsFullPath;
    }
    public function getBreadcrumbsAttribute()
    {
        return CategoryService::breadcrumbs($this);

    }


}
