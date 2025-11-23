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
        return Storage::disk('public')->url($this->path);
    }
}
