<?php

namespace App\Http\Resources\ProductParent;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductParentResource extends JsonResource
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
            'category_id'=>$this->category_id,
            'category_title'=>$this->category_title,
        ];
    }
}
