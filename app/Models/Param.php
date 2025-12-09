<?php

namespace App\Models;

use App\Enums\Param\ParamFilterTypeEnum;
use App\Models\Traits\HasFilter;
use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    use HasFilter;
    public function getFilterTypeTitleAttribute()
    {
        return ParamFilterTypeEnum::map()[$this->filter_type];
    }
}
