<?php

namespace App\Http\Resources\Seller;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerProductApiResource extends JsonResource
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
            // "brand_details" => SellerBrandApiResource::collection(collect([Brand::find($this->brand_id)])),
            "brand_details" => [
                'id' => $this->brand->id,
                'name_en' => $this->brand->name_en,
            ],
            "category_details" => [
                'id' => $this->category->id,
                'name_en' => $this->category->name_en,
            ],
            "tags" => $this->tags,
            "url" => $this->url,
            "vendor_id" => $this->vendor_id,
            "seller_id" => $this->seller_id,
            "stock_qty" => $this->stock_qty,
        ];
    }
}
