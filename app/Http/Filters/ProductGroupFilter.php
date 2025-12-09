<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductGroupFilter extends AbstractFilter
{
    protected array $keys = [
        'title'
    ];

    protected function title(Builder $builder, $value)
    {

        return $builder->where('title', 'like', '%'.$value.'%');
    }
}
