<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;


class CategoryFilter extends AbstractFilter
{
    protected array $keys = [
        'parent_title',
        'title',
        'created_at_from',
        'created_at_to',
    ];



    protected function parentTitle(Builder $builder, $value)
    {
        $builder->whereRelation('parent', 'title', 'like', '%' . $value . '%');

    }

    protected function title(Builder $builder, $value)
    {
        $builder->where('title', 'like', '%' . $value . '%');
    }

    protected function createdAtFrom(Builder $builder, $value)
    {
        $builder->whereDate('created_at', '>=', $value);
    }

    protected function createdAtTo(Builder $builder, $value)
    {
        $builder->whereDate('created_at', '<=', $value);
    }

}

