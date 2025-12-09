<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends AbstractFilter
{
    protected array $keys = [
        'product_group_title',
        'category_title',
        'title',
        'description',
        'content',
        'price_from',
        'price_to',
        'old_price_from',
        'old_price_to',
        'qty_from',
        'qty_to',
        'article',
        'created_at_from',
        'created_at_to',
        'updated_at_from',
        'updated_at_to',
    ];

    protected function title(Builder $builder, $value)
    {
        return $builder->where('title', 'like', '%'.$value.'%');
    }
    protected function productGroupTitle(Builder $builder, $value)
    {
        return $builder->whereRelation('productGroup','title', 'like', '%'.$value.'%');
    }
    protected function categoryTitle(Builder $builder, $value)
    {
        return $builder->whereRelation('category','title', 'like', '%'.$value.'%');
    }
    protected function description(Builder $builder, $value)
    {
        return $builder->where('description', 'like', '%'.$value.'%');
    }
    protected function content(Builder $builder, $value)
    {
        return $builder->where('content', 'like', '%'.$value.'%');
    }
    protected function article(Builder $builder, $value)
    {
        return $builder->where('article', 'like', '%'.$value.'%');
    }
    protected function createdAtFrom(Builder $builder, $value)
    {
        $builder->whereDate('created_at', '>=', $value);
    }

    protected function priceFrom(Builder $builder, $value)
    {
        $builder->where('price', '>=', $value);
    }
    protected function priceTo(Builder $builder, $value)
    {
        $builder->where('price', '<=', $value);
    }
    protected function oldPriceFrom(Builder $builder, $value)
    {
        $builder->where('old_price', '>=', $value);
    }
    protected function oldPriceTo(Builder $builder, $value)
    {
        $builder->where('old_price', '<=', $value);
    }
    protected function qtyFrom(Builder $builder, $value)
    {
        $builder->where('qty', '>=', $value);
    }
    protected function qtyTo(Builder $builder, $value)
    {

        $builder->where('qty', '<=', $value);
    }

    protected function createdAtTo(Builder $builder, $value)
    {
        $builder->whereDate('created_at', '<=', $value);
    }
    protected function updatedAtFrom(Builder $builder, $value)
    {
        $builder->whereDate('updated_at', '>=', $value);
    }

    protected function updateddAtTo(Builder $builder, $value)
    {
        $builder->whereDate('updated_at', '<=', $value);
    }

}

