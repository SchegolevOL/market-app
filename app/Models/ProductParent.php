<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductParent extends Model
{
    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategoryTitleAttribute()
    {
        $category=Category::query()->where('id',$this->category_id)->first();

        return $category->title;
    }
}
