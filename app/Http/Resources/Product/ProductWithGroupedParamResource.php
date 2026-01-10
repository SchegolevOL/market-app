<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Image\ImageResource;
use App\Http\Resources\Param\ParamResource;
use App\Http\Resources\Param\ParamWithsPivotValueResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductWithGroupedParamResource extends JsonResource
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
            'product_group' => $this->productGroup,
            'group_products' => ProductResource::collection($this->group_products)->resolve(),
            'category' => $this->category,
            'parent_id' => $this->parent_id,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'has_children' => $this->has_children,
            'qty' => $this->qty,
            'article' => $this->article,
            'images'=> ImageResource::collection($this->images)->resolve(),
            'params'=> $this->grouped_params
        ];
    }
}
