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
        'param_title_value',

        'integer',
        'select',
        'checkbox',

    ];

    protected function title(Builder $builder, $value)
    {
        return $builder->where('title', 'like', '%' . $value . '%');
    }

    protected function productGroupTitle(Builder $builder, $value)
    {
        return $builder->whereRelation('productGroup', 'title', 'like', '%' . $value . '%');
    }

    protected function categoryTitle(Builder $builder, $value)
    {
        return $builder->whereRelation('category', 'title', 'like', '%' . $value . '%');
    }

    protected function description(Builder $builder, $value)
    {
        return $builder->where('description', 'like', '%' . $value . '%');
    }

    protected function content(Builder $builder, $value)
    {
        return $builder->where('content', 'like', '%' . $value . '%');
    }

    protected function article(Builder $builder, $value)
    {
        return $builder->where('article', 'like', '%' . $value . '%');
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

    protected function paramTitleValue(Builder $builder, $data)
    {
        $title = $data['title'];
        $value = $data['value'];
        $builder->whereRelation('params', 'title', 'like', '%' . $title . '%')
            ->whereRelation('params', 'value', '=', $value);
    }

    /*Фильтры для Клиента*/
    public function integer(Builder $builder, $data)
    {
        if (isset($data['from'])) {
            $builder->whereHas('paramProduct', function ($query) use ($data) {
                foreach ($data['from'] as $key => $value) {
                    $query->where('param_id', $key)->whereRaw('CAST(value AS INT) >= ?', $value);
                }
            });
        }
        if (isset($data['to'])) {
            $builder->whereHas('paramProduct', function ($query) use ($data) {
                foreach ($data['filters']['integer']['to'] as $key => $value) {
                    $query->where('param_id', $key)->whereRaw('CAST(value AS INT) <= ?', $value);
                }
            });
        }
    }

    public function select(Builder $builder, $data)
    {
        $builder->whereHas('paramProduct', function ($query) use ($data) {
            foreach ($data as $key => $value) {
                $query->where('param_id', $key)->where('value', $value);
            }
        });
    }

    public function checkbox(Builder $builder, $data)
    {
        $builder->whereHas('paramProduct', function ($query) use ($data) {
            foreach ($data as $key => $value) {
                $query->where('param_id', $key)->whereIn('value', $value);
            }
        });
    }



}

