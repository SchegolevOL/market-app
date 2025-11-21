<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryViewResource extends JsonResource
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
            'images_url'=>$this->image_urls,
            'breadcrumbs' => $this->breadcrumbs,

        ];
    }
}
