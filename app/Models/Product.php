<?php

namespace App\Models;

use App\Models\Traits\HasFilter;
use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

#[ObservedBy(ProductObserver::class)]
class Product extends Model
{
    use HasFilter;

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function params(): BelongsToMany
    {
        return $this->belongsToMany(Param::class)->withPivot('value');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Product::class, 'parent_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'parent_id', 'id');
    }

    public function siblingProducts()
    {

        //return $this->parent->children()->whereNot('id', $this->id);
        return $this->parent->children();
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function productGroup(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class, 'product_group_id', 'id');
    }

    public function getGroupProductsAttribute(): Collection
    {
        return $this->productGroup
            ->products()
            ->whereNot('parent_id', $this->parent_id)
            ->distinct('parent_id')
            ->get();
    }

    public function scopeByCategories(Builder $builder, Collection $categoryChildren): Builder
    {
        return $builder->whereIn('category_id', $categoryChildren->pluck('id'))
            ->whereNotNull('parent_id');
    }

    public function paramProduct()
    {
        return $this->hasMany(ParamProduct::class, 'product_id', 'id');
    }


    public function getHasChildrenAttribute()
    {
        return $this->children()->exists();
    }

    public function getGroupedParamsAttribute()
    {
        return $this->params->groupBy('title')->map(function ($param) {
            return [
                'title' => $param->first()->title,
                'value' => $param->pluck('pivot.value')->toArray(),
                'label' => $param->first()->label,
            ];
        })->values()->toArray();
    }


}
