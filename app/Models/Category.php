<?php

namespace App\Models;

use App\Http\Filters\CategoryFilter;
use App\Models\Traits\HasFilter;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Storage;
use function Laravel\Prompts\warning;

class Category extends Model
{
    use HasFilter;

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function paramProducts():HasManyThrough
    {
        //return $this->hasManyThrough(Product::class, Category::class,'category_id', 'id', 'parent_id', 'id');
        return $this->hasManyThrough(ParamProduct::class, Product::class, 'category_id', 'product_id', 'id', 'id');
    }
    public function getParentTitleAttribute()
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
