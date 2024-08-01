<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDefaultResource extends JsonResource
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
            "id" => $this->id,
            "name_en" => $this->name_en ?? "",
            "name_bn" => $this->name_bn ?? "",
            "regular_price" => $this->regular_price ?? "",
            "discount_price" => $this->discount_price ?? "",
            "discount_type" => $this->discount_type ?? "",
            "stock_qty" => $this->stock_qty ?? "",
            "product_thumbnail" => $this->product_thumbnail ?? "",
            "description_en" => strip_tags($this->description_en) ?? "",
            "description_bn" => strip_tags($this->description_bn) ?? "",
            "brand_name" => $this->brand->name_en ?? "",
            "category_name" => $this->category->name_en ?? "",
            "tags" => $this->tags ?? "",
            "unit_weight" => $this->unit_weight ?? "",
            "rating_count" => $this->rating_count ?? "",
            "average_rating" => $this->average_rating ?? "",
        ];
    }
}
