<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Product\ProductDefaultResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name_en' => $this->name_en ?? "",
            'name_bn' => $this->name_bn ?? "",
            'slug' => $this->slug ?? "",
            "description_en" => strip_tags($this->description_en) ?? "",
            "description_bn" => strip_tags($this->description_bn) ?? "",
            'image' => $this->image ?? "",
            'parent_id' => $this->parent_id ?? 0,
            'type' => $this->type ?? "",
            'is_featured' => $this->is_featured ?? 0,
            'status' => $this->status ?? "",
            'products' => ProductDefaultResource::collection($this->products),
        ];
    }
}
