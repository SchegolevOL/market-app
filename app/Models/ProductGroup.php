<?php

namespace App\Models;

use App\Models\Traits\HasFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductGroup extends Model
{
    use HasFilter;
    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategoryTitleAttribute()
    {
        $category=Category::query()->where('id',$this->category_id)->first();

        return $category->title;
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->whereNotNull('parent_id');
    }
}
