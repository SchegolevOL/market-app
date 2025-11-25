<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Image\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'parent'=>$this->parent,
            'parent_id'=>$this->parent_id,
            'images'=> ImageResource::collection($this->images)->resolve(),
        ];
    }
}
