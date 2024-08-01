<?php

namespace App\Http\Resources\Seller;
use App\Http\Resources\Seller\SellerUserApiResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerCategoryApiResource extends JsonResource
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
                    "name_en"=> $this->name_en,
                    "name_bn"=> $this->name_bn,
                    "slug"=> $this->name_bn,
                    "description_en"=> $this->description_en,
                    "description_bn"=> $this->description_bn,
                    "image"=> $this->image,
                    "seller_id"=> $this->seller_id,
                    "type"=> $this->type,
                    "is_featured"=> $this->is_featured,
                    "status"=> $this->status,
                    "created_by" => SellerUserApiResource::collection(collect([User::find($this->created_by)])),

        ];
    }
}
