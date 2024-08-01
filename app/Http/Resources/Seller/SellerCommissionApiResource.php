<?php

namespace App\Http\Resources\Seller;

use App\Http\Resources\Seller\SellerCategoryApiResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerCommissionApiResource extends JsonResource
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
            "category_details" =>  SellerCategoryApiResource::collection(collect([$this->category])),
            "commission_percentage" => $this->commission_percentage,
        ];
    }
}
