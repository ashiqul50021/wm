<?php

namespace App\Http\Resources\Seller;

use Illuminate\Http\Resources\Json\JsonResource;

class SellerAuthApiResource extends JsonResource
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
            'user' => [
                'id' => $this->id,
                'name' => $this->name,
                'username' => $this->username,
                'phone' => $this->phone,
                'email' => $this->email,
            ],

            'seller_details' => $this->seller ?[
                'id' => $this->seller_id,
                'shop_name' => $this->shop_name,
                'slug' => $this->slug,
                'user_id' => $this->seller->user_id,
                'address' => $this->address,
                'commission' => $this->commission ?? '',
                'description' => $this->description,
                'shop_profile' => $this->shop_profile,
                'shop_cover' => $this->shop_cover,
                'nid' => $this->nid,
                'google_map_url' => $this->google_map_url,
                'trade_license' => $this->trade_license,
                'status' => $this->status ? 1 : 0,
                'created_by' => null,
            ]: 0,

        ];
    }
}
