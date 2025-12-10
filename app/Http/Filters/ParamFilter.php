<?php

namespace App\Http\Filters;

use App\Enums\Param\ParamFilterTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ParamFilter extends AbstractFilter
{
    protected array $keys = [
        'title',
        'type_title'
    ];

    protected function title(Builder $builder, $value)
    {

        return $builder->where('title', 'like', '%'.$value.'%');
    }


    protected function typeTitle(Builder $builder, $value){

        $value = Str::lower($value);

        $types = [];
        $enum = ParamFilterTypeEnum::map();

        for ($i=1; $i<=count($enum); $i++) {
            if(str_contains($enum[$i], $value)){
                $types[] = $i;
            }
        }

        return $builder->whereIn('filter_type', $types);
    }

}
