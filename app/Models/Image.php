<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    public function imageable()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        // Если изображение внешнее (type = 'external'), возвращаем path как URL
        if ($this->type === 'external') {
            return $this->path;
        }
        // Иначе используем Storage disk
        return Storage::disk('public')->url($this->path);
    }
}
